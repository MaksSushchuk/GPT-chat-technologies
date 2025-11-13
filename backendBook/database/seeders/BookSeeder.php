<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book; // не забудь імпорт моделі

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = '[
          {
            "title": "Harry Potter and the Philosopher\'s Stone",
            "author": "J.K. Rowling",
            "genres": ["Fantasy", "Young Adult", "Adventure"],
            "description": "Хлопчик-сирота дізнається, що він чарівник, потрапляє до школи магії Гоґвартс і вперше стикається з темною силою, яка полювала на нього з дитинства.",
            "rating": 4.8
          },
          {
            "title": "Percy Jackson & The Lightning Thief",
            "author": "Rick Riordan",
            "genres": ["Fantasy", "Young Adult", "Adventure"],
            "description": "Персі Джексон дізнається, що він напівбог, син Посейдона, і має повернути викрадений грім Зевса, подорожуючи сучасною Америкою, наповненою грецькими міфами.",
            "rating": 4.5
          },
          {
            "title": "The Chronicles of Narnia: The Lion, the Witch and the Wardrobe",
            "author": "C.S. Lewis",
            "genres": ["Fantasy", "Children", "Adventure"],
            "description": "Четверо дітей знаходять магічну країну Нарнію через стару шафу та долучаються до боротьби проти Білої Відьми разом з левом Асланом.",
            "rating": 4.4
          },
          {
            "title": "Eragon",
            "author": "Christopher Paolini",
            "genres": ["Fantasy", "Young Adult", "Adventure"],
            "description": "Юнак Ерагон знаходить таємниче яйце дракона, стає Вершником і втягується у боротьбу проти тиранічного короля, відкриваючи у собі магічні здібності.",
            "rating": 4.2
          },
          {
            "title": "The Hobbit",
            "author": "J.R.R. Tolkien",
            "genres": ["Fantasy", "Adventure", "Classic"],
            "description": "Більбо Торбин, спокійний гобіт, вирушає в небезпечну пригоду з гномами, щоб повернути їхній дім у підгорі від дракона Смауга.",
            "rating": 4.7
          },
          {
            "title": "The Lord of the Rings: The Fellowship of the Ring",
            "author": "J.R.R. Tolkien",
            "genres": ["Fantasy", "Epic", "Adventure"],
            "description": "Фродо Бегінс отримує Кільце Всевладдя і разом з Братством Кільця мусить віднести його в Мордор, щоб знищити й зупинити Саурона.",
            "rating": 4.9
          },
          {
            "title": "Mistborn: The Final Empire",
            "author": "Brandon Sanderson",
            "genres": ["Fantasy", "Epic", "Magic"],
            "description": "Світ, де попіл падає з неба, а безсмертний Лорд-Владика править тисячі років. Злодійка Він відкриває у собі силу тумароджених і долучається до змови проти імперії.",
            "rating": 4.6
          },
          {
            "title": "The Name of the Wind",
            "author": "Patrick Rothfuss",
            "genres": ["Fantasy", "Epic", "Drama"],
            "description": "Квоут, легендарний маг і музикант, розповідає історію свого життя: дитинство в трупі акторів, навчання в університеті та пошуки таємничих істот Чандрійців.",
            "rating": 4.5
          },
          {
            "title": "The Golden Compass",
            "author": "Philip Pullman",
            "genres": ["Fantasy", "Young Adult", "Adventure"],
            "description": "Лайра Белаква живе у паралельному світі з демонів-супутниками та відправляється на північ, щоб врятувати викрадених дітей і розкрити таємницю Пилу.",
            "rating": 4.1
          },
          {
            "title": "A Game of Thrones",
            "author": "George R.R. Martin",
            "genres": ["Fantasy", "Epic", "Political"],
            "description": "Шляхетні роди Вестероса борються за Залізний Трон, тоді як на півночі прокидається давнє зло, а за вузьким морем формується нова загроза.",
            "rating": 4.7
          },
          {
            "title": "The Maze Runner",
            "author": "James Dashner",
            "genres": ["Science Fiction", "Dystopia", "Young Adult"],
            "description": "Томас прокидається в лабіринті без спогадів про минуле. Разом з іншими підлітками він намагається вибратися із смертельно небезпечного середовища.",
            "rating": 3.9
          },
          {
            "title": "Divergent",
            "author": "Veronica Roth",
            "genres": ["Science Fiction", "Dystopia", "Young Adult"],
            "description": "У суспільстві, поділеному на фракції за рисами характеру, Тріс виявляє, що є дивергенткою й не вписується в систему, що робить її мішенню.",
            "rating": 4.0
          },
          {
            "title": "The Hunger Games",
            "author": "Suzanne Collins",
            "genres": ["Science Fiction", "Dystopia", "Young Adult"],
            "description": "Кітнісс Евердін добровільно йде на смертельні Ігри, щоб врятувати сестру, і стає символом повстання проти жорстокого режиму Капітолію.",
            "rating": 4.3
          },
          {
            "title": "Shadow and Bone",
            "author": "Leigh Bardugo",
            "genres": ["Fantasy", "Young Adult", "Romance"],
            "description": "Аліна Старков виявляє рідкісну магічну силу, здатну знищити Темну Розколину, і потрапляє до ґріша-двору, де все не так однозначно, як здається.",
            "rating": 4.0
          },
          {
            "title": "Six of Crows",
            "author": "Leigh Bardugo",
            "genres": ["Fantasy", "Heist", "Young Adult"],
            "description": "Каз Бреккер збирає команду злочинців для неможливої крадіжки в надзвичайно захищеній фортеці, де ставки — життя, гроші і доля всього світу магії.",
            "rating": 4.6
          },
          {
            "title": "The Magicians",
            "author": "Lev Grossman",
            "genres": ["Fantasy", "Urban Fantasy", "Adult"],
            "description": "Квентін потрапляє до таємного магічного університету і дізнається, що вигаданий улюблений світ дитинства існує насправді, але значно темніший.",
            "rating": 3.8
          },
          {
            "title": "The Last Wish",
            "author": "Andrzej Sapkowski",
            "genres": ["Fantasy", "Dark Fantasy", "Short Stories"],
            "description": "Ґеральт із Рівії, відьмак-мутант, подорожує світом, виконуючи замовлення на чудовиськ, і стикається з політикою, прокляттями та моральними дилемами.",
            "rating": 4.4
          },
          {
            "title": "The Way of Kings",
            "author": "Brandon Sanderson",
            "genres": ["Fantasy", "Epic", "High Fantasy"],
            "description": "На світі, де нескінченні бурі формують життя людей, кілька героїв — раб-воїн, падший воєначальник і вчена — отримують силу, що може змінити історію.",
            "rating": 4.8
          },
          {
            "title": "Good Omens",
            "author": "Neil Gaiman & Terry Pratchett",
            "genres": ["Fantasy", "Comedy", "Apocalypse"],
            "description": "Ангел і демон, які надто звикли до життя на Землі, вирішують разом запобігти Апокаліпсису, але випадково гублять Антихриста.",
            "rating": 4.2
          },
          {
            "title": "American Gods",
            "author": "Neil Gaiman",
            "genres": ["Fantasy", "Mythology", "Urban Fantasy"],
            "description": "Шедоу Мун виходить із в\'язниці та знайомиться з містером Середою, який втягує його в війну між старими богами міфів і новими богами сучасного світу.",
            "rating": 4.1
          }
        ]';

        $data = json_decode($json, true); // асоціативні масиви

        foreach ($data as $book) {
            Book::query()->create($book);
        }
    }
}
