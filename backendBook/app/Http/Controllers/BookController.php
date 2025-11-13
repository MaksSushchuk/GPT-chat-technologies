<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA; // <- ДОДАЙ ЦЕ
use Illuminate\Support\Str; // ← оце додай

/**
 * @OA\Info(
 *     title="Book Recommendation API",
 *     version="1.0.0",
 *     description="API для рекомендації книг на основі NLP та схожості описів."
 * )
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recommend",
     *     tags={"Books"},
     *     summary="Рекомендації книг за схожістю",
     *     description="Повертає список книг, схожих на вказану, використовуючи аналіз тексту (назва, жанри, опис) та косинусну схожість.",
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=true,
     *         description="Назва книги, для якої потрібно знайти схожі",
     *         @OA\Schema(
     *             type="string",
     *             example="Harry Potter and the Philosopher's Stone"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список рекомендованих книг",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="input_book",
     *                 type="string",
     *                 example="Harry Potter and the Philosopher's Stone"
     *             ),
     *             @OA\Property(
     *                 property="recommendations",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         example="Percy Jackson & The Lightning Thief"
     *                     ),
     *                     @OA\Property(
     *                         property="author",
     *                         type="string",
     *                         example="Rick Riordan"
     *                     ),
     *                     @OA\Property(
     *                         property="genres",
     *                         type="array",
     *                         @OA\Items(type="string"),
     *                         example={"Fantasy", "Young Adult", "Adventure"}
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="Молодий герой, грецька міфологія, магія..."
     *                     ),
     *                     @OA\Property(
     *                         property="similarity",
     *                         type="number",
     *                         format="float",
     *                         description="Відсоток схожості (0–100)",
     *                         example=92.13
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Не передано параметр title",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Параметр title є обовʼязковим. Наприклад: /api/recommend?title=Harry%20Potter"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Книга не знайдена",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Книгу не знайдено за назвою: Harry Potter"
     *             )
     *         )
     *     )
     * )
     */
    public function recommend(Request $request)
    {
        $title = $request->query('title');

        if (!$title) {
            return response()->json([
                'error' => 'Параметр "title" є обовʼязковим. Наприклад: /api/recommend?title=Harry%20Potter'
            ], 400);
        }

        $sourceBook = Book::where('title', 'LIKE', "%{$title}%")->first();

        if (!$sourceBook) {
            return response()->json([
                'error' => 'Книгу не знайдено за назвою: ' . $title,
            ], 404);
        }

        $sourceText = $this->buildTextForNlp($sourceBook);
        $sourceVector = $this->textToVector($sourceText);

        $candidates = Book::where('id', '!=', $sourceBook->id)->get();

        $results = [];

        foreach ($candidates as $book) {
            $text = $this->buildTextForNlp($book);
            $vector = $this->textToVector($text);

            $similarity = $this->cosineSimilarity($sourceVector, $vector); // 0..1

            $results[] = [
                'title'       => $book->title,
                'author'      => $book->author,
                'genres'      => $book->genres,
                'description' => Str::limit($book->description, 180),
                'similarity'  => round($similarity * 100, 2), // у відсотках
            ];
        }

        usort($results, fn($a, $b) => $b['similarity'] <=> $a['similarity']);
        $results = array_slice($results, 0, 5);

        return response()->json([
            'input_book'    => $sourceBook->title,
            'recommendations' => $results,
        ]);
    }

    /**
     * Склеюємо назву + жанри + опис в один рядок для подальшого аналізу.
     */
    private function buildTextForNlp(Book $book): string
    {
        $genres = is_array($book->genres) ? implode(' ', $book->genres) : '';
        return $book->title . ' ' . $book->author . ' ' . $genres . ' ' . $book->description;
    }

    /**
     * Дуже простий NLP: перетворюємо текст у вектор частот слів.
     * (bag-of-words з мінімальною очисткою).
     */
    private function textToVector(string $text): array
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^a-zа-яіїє0-9\s]+/u', ' ', $text);
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        $stopWords = [
            'і','та','але','що','це','як','в','у','на','до','з','за','the','a','an','of','for','to','in','and','or','is','are','was','were'
        ];

        $freq = [];

        foreach ($words as $w) {
            if (mb_strlen($w, 'UTF-8') <= 2) continue;
            if (in_array($w, $stopWords, true)) continue;

            if (!isset($freq[$w])) {
                $freq[$w] = 0;
            }
            $freq[$w] += 1;
        }

        return $freq;
    }

    /**
     * Коссинусна схожість між двома векторами (у вигляді word=>tf).
     */
    private function cosineSimilarity(array $vec1, array $vec2): float
    {
        if (empty($vec1) || empty($vec2)) {
            return 0.0;
        }

        $dot = 0;
        $normA = 0;
        $normB = 0;

        foreach ($vec1 as $word => $value) {
            $normA += $value * $value;
            if (isset($vec2[$word])) {
                $dot += $value * $vec2[$word];
            }
        }

        foreach ($vec2 as $value) {
            $normB += $value * $value;
        }

        if ($normA == 0 || $normB == 0) {
            return 0.0;
        }

        return $dot / (sqrt($normA) * sqrt($normB));
    }
}
