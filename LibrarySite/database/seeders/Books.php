<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class Books extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $books = [
            ['book_name' => '1984', 'author' => 'George Orwell', 'page_count' => 328, 'category_id' => $categories->random()->id, 'isbn' => '9780451524935', 'publisher' => 'Penguin Books', 'publish_year' => '1949', 'status' => 'mevcut'],
            ['book_name' => 'Bülbülü Öldürmek', 'author' => 'Harper Lee', 'page_count' => 281, 'category_id' => $categories->random()->id, 'isbn' => '9780446310789', 'publisher' => 'Grand Central', 'publish_year' => '1960', 'status' => 'mevcut'],
            ['book_name' => 'Muhteşem Gatsby', 'author' => 'F. Scott Fitzgerald', 'page_count' => 180, 'category_id' => $categories->random()->id, 'isbn' => '9780743273565', 'publisher' => 'Scribner', 'publish_year' => '1925', 'status' => 'mevcut'],
            ['book_name' => 'Don Kişot', 'author' => 'Miguel de Cervantes', 'page_count' => 863, 'category_id' => $categories->random()->id, 'isbn' => '9780060934347', 'publisher' => 'Ecco', 'publish_year' => '1605', 'status' => 'mevcut'],
            ['book_name' => 'Yüzüklerin Efendisi', 'author' => 'J.R.R. Tolkien', 'page_count' => 1178, 'category_id' => $categories->random()->id, 'isbn' => '9780618640157', 'publisher' => 'Mariner Books', 'publish_year' => '1954', 'status' => 'mevcut'],
            ['book_name' => 'Gurur ve Önyargı', 'author' => 'Jane Austen', 'page_count' => 432, 'category_id' => $categories->random()->id, 'isbn' => '9780141439518', 'publisher' => 'Penguin Classics', 'publish_year' => '1813', 'status' => 'mevcut'],
            ['book_name' => 'Hobbit', 'author' => 'J.R.R. Tolkien', 'page_count' => 310, 'category_id' => $categories->random()->id, 'isbn' => '9780547928227', 'publisher' => 'Houghton Mifflin', 'publish_year' => '1937', 'status' => 'mevcut'],
            ['book_name' => 'Savaş ve Barış', 'author' => 'Leo Tolstoy', 'page_count' => 1225, 'category_id' => $categories->random()->id, 'isbn' => '9780192833983', 'publisher' => 'Oxford University Press', 'publish_year' => '1869', 'status' => 'mevcut'],
            ['book_name' => 'Çavdar Tarlasında Çocuklar', 'author' => 'J.D. Salinger', 'page_count' => 234, 'category_id' => $categories->random()->id, 'isbn' => '9780316769488', 'publisher' => 'Little, Brown', 'publish_year' => '1951', 'status' => 'mevcut'],
            ['book_name' => 'Cesur Yeni Dünya', 'author' => 'Aldous Huxley', 'page_count' => 311, 'category_id' => $categories->random()->id, 'isbn' => '9780060850524', 'publisher' => 'Harper Perennial', 'publish_year' => '1932', 'status' => 'mevcut'],
            ['book_name' => 'Odysseia', 'author' => 'Homeros', 'page_count' => 541, 'category_id' => $categories->random()->id, 'isbn' => '9780140268867', 'publisher' => 'Penguin Classics', 'publish_year' => '1800', 'status' => 'mevcut'],
            ['book_name' => 'Jane Eyre', 'author' => 'Charlotte Bronte', 'page_count' => 532, 'category_id' => $categories->random()->id, 'isbn' => '9780141441146', 'publisher' => 'Penguin Classics', 'publish_year' => '1847', 'status' => 'mevcut'],
            ['book_name' => 'İlahi Komedya', 'author' => 'Dante Alighieri', 'page_count' => 798, 'category_id' => $categories->random()->id, 'isbn' => '9780451208637', 'publisher' => 'Signet Classics', 'publish_year' => '1320', 'status' => 'mevcut'],
            ['book_name' => 'Suç ve Ceza', 'author' => 'Fyodor Dostoevsky', 'page_count' => 671, 'category_id' => $categories->random()->id, 'isbn' => '9780143058144', 'publisher' => 'Penguin Classics', 'publish_year' => '1866', 'status' => 'mevcut'],
            ['book_name' => 'Dorian Gray\'in Portresi', 'author' => 'Oscar Wilde', 'page_count' => 254, 'category_id' => $categories->random()->id, 'isbn' => '9780141439570', 'publisher' => 'Penguin Classics', 'publish_year' => '1890', 'status' => 'mevcut'],
            ['book_name' => 'Uğultulu Tepeler', 'author' => 'Emily Bronte', 'page_count' => 342, 'category_id' => $categories->random()->id, 'isbn' => '9780141439556', 'publisher' => 'Penguin Classics', 'publish_year' => '1847', 'status' => 'mevcut'],
            ['book_name' => 'Karamazov Kardeşler', 'author' => 'Fyodor Dostoevsky', 'page_count' => 824, 'category_id' => $categories->random()->id, 'isbn' => '9780374528379', 'publisher' => 'FSG Classics', 'publish_year' => '1880', 'status' => 'mevcut'],
            ['book_name' => 'Sefiller', 'author' => 'Victor Hugo', 'page_count' => 1463, 'category_id' => $categories->random()->id, 'isbn' => '9780451419439', 'publisher' => 'Signet Classics', 'publish_year' => '1862', 'status' => 'mevcut'],
            ['book_name' => 'Monte Kristo Kontu', 'author' => 'Alexandre Dumas', 'page_count' => 1276, 'category_id' => $categories->random()->id, 'isbn' => '9780140449266', 'publisher' => 'Penguin Classics', 'publish_year' => '1844', 'status' => 'mevcut'],
            ['book_name' => 'Anna Karenina', 'author' => 'Leo Tolstoy', 'page_count' => 864, 'category_id' => $categories->random()->id, 'isbn' => '9780143035008', 'publisher' => 'Penguin Classics', 'publish_year' => '1877', 'status' => 'mevcut'],
            ['book_name' => 'İlyada', 'author' => 'Homeros', 'page_count' => 683, 'category_id' => $categories->random()->id, 'isbn' => '9780140275360', 'publisher' => 'Penguin Classics', 'publish_year' => '1800', 'status' => 'mevcut'],
            ['book_name' => 'Büyük Umutlar', 'author' => 'Charles Dickens', 'page_count' => 544, 'category_id' => $categories->random()->id, 'isbn' => '9780141439563', 'publisher' => 'Penguin Classics', 'publish_year' => '1861', 'status' => 'mevcut'],
            ['book_name' => 'Canterbury Hikayeleri', 'author' => 'Geoffrey Chaucer', 'page_count' => 504, 'category_id' => $categories->random()->id, 'isbn' => '9780140424386', 'publisher' => 'Penguin Classics', 'publish_year' => '1400', 'status' => 'mevcut'],
            ['book_name' => 'Moby Dick', 'author' => 'Herman Melville', 'page_count' => 720, 'category_id' => $categories->random()->id, 'isbn' => '9780142437247', 'publisher' => 'Penguin Classics', 'publish_year' => '1851', 'status' => 'mevcut'],
            ['book_name' => 'Gazap Üzümleri', 'author' => 'John Steinbeck', 'page_count' => 464, 'category_id' => $categories->random()->id, 'isbn' => '9780143039433', 'publisher' => 'Penguin Classics', 'publish_year' => '1939', 'status' => 'mevcut']
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
