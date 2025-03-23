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
            ['book_name' => '1984', 'author' => 'George Orwell', 'page_count' => 328, 'category_id' => $categories->random()->id, 'isbn' => '9780451524935', 'publisher' => 'Penguin Books', 'publish_year' => '1949', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1657781256i/5470.jpg'],
            ['book_name' => 'Bülbülü Öldürmek', 'author' => 'Harper Lee', 'page_count' => 281, 'category_id' => $categories->random()->id, 'isbn' => '9780446310789', 'publisher' => 'Grand Central', 'publish_year' => '1960', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1553383690i/2657.jpg'],
            ['book_name' => 'Muhteşem Gatsby', 'author' => 'F. Scott Fitzgerald', 'page_count' => 180, 'category_id' => $categories->random()->id, 'isbn' => '9780743273565', 'publisher' => 'Scribner', 'publish_year' => '1925', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1490528560i/4671.jpg'],
            ['book_name' => 'Don Kişot', 'author' => 'Miguel de Cervantes', 'page_count' => 863, 'category_id' => $categories->random()->id, 'isbn' => '9780060934347', 'publisher' => 'Can Yayınları', 'publish_year' => '1605', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546112331i/3836.jpg'],
            ['book_name' => 'Yüzüklerin Efendisi', 'author' => 'J.R.R. Tolkien', 'page_count' => 1178, 'category_id' => $categories->random()->id, 'isbn' => '9780618640157', 'publisher' => 'Metis Yayınları', 'publish_year' => '1954', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1566425108i/33.jpg'],
            ['book_name' => 'Aşk ve Gurur', 'author' => 'Jane Austen', 'page_count' => 432, 'category_id' => $categories->random()->id, 'isbn' => '9780141439518', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1813', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1320399351i/1885.jpg'],
            ['book_name' => 'Hobbit', 'author' => 'J.R.R. Tolkien', 'page_count' => 310, 'category_id' => $categories->random()->id, 'isbn' => '9780547928227', 'publisher' => 'Metis Yayınları', 'publish_year' => '1937', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546071216i/5907.jpg'],
            ['book_name' => 'Savaş ve Barış', 'author' => 'Leo Tolstoy', 'page_count' => 1225, 'category_id' => $categories->random()->id, 'isbn' => '9780192833983', 'publisher' => 'Yapı Kredi Yayınları', 'publish_year' => '1869', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1413215930i/656.jpg'],
            ['book_name' => 'Çavdar Tarlasında Çocuklar', 'author' => 'J.D. Salinger', 'page_count' => 234, 'category_id' => $categories->random()->id, 'isbn' => '9780316769488', 'publisher' => 'Yapı Kredi Yayınları', 'publish_year' => '1951', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1398034300i/5107.jpg'],
            ['book_name' => 'Cesur Yeni Dünya', 'author' => 'Aldous Huxley', 'page_count' => 311, 'category_id' => $categories->random()->id, 'isbn' => '9780060850524', 'publisher' => 'İthaki Yayınları', 'publish_year' => '1932', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1575509280i/5129.jpg'],
            ['book_name' => 'Odysseia', 'author' => 'Homer', 'page_count' => 541, 'category_id' => $categories->random()->id, 'isbn' => '9780140268867', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1800', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1390173285i/1381.jpg'],
            ['book_name' => 'Jane Eyre', 'author' => 'Charlotte Bronte', 'page_count' => 532, 'category_id' => $categories->random()->id, 'isbn' => '9780141441146', 'publisher' => 'Can Yayınları', 'publish_year' => '1847', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1557343311i/10210.jpg'],
            ['book_name' => 'İlahi Komedya', 'author' => 'Dante Alighieri', 'page_count' => 798, 'category_id' => $categories->random()->id, 'isbn' => '9780451208637', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1320', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1390262666i/6656.jpg'],
            ['book_name' => 'Suç ve Ceza', 'author' => 'Fyodor Dostoyevski', 'page_count' => 671, 'category_id' => $categories->random()->id, 'isbn' => '9780143058144', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1866', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1382846449i/7144.jpg'],
            ['book_name' => 'Dorian Gray\'in Portresi', 'author' => 'Oscar Wilde', 'page_count' => 254, 'category_id' => $categories->random()->id, 'isbn' => '9780141439570', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1890', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1546103428i/5297.jpg'],
            ['book_name' => 'Uğultulu Tepeler', 'author' => 'Emily Bronte', 'page_count' => 342, 'category_id' => $categories->random()->id, 'isbn' => '9780141439556', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1847', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388212715i/6185.jpg'],
            ['book_name' => 'Karamazov Kardeşler', 'author' => 'Fyodor Dostoyevski', 'page_count' => 824, 'category_id' => $categories->random()->id, 'isbn' => '9780374528379', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1880', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1427728126i/4934.jpg'],
            ['book_name' => 'Sefiller', 'author' => 'Victor Hugo', 'page_count' => 1463, 'category_id' => $categories->random()->id, 'isbn' => '9780451419439', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1862', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1411852091i/24280.jpg'],
            ['book_name' => 'Monte Kristo Kontu', 'author' => 'Alexandre Dumas', 'page_count' => 1276, 'category_id' => $categories->random()->id, 'isbn' => '9780140449266', 'publisher' => 'Can Yayınları', 'publish_year' => '1844', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1611834134i/7126.jpg'],
            ['book_name' => 'Anna Karenina', 'author' => 'Lev Tolstoy', 'page_count' => 864, 'category_id' => $categories->random()->id, 'isbn' => '9780143035008', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1877', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1601352433i/15823480.jpg'],
            ['book_name' => 'İlyada', 'author' => 'Homeros', 'page_count' => 683, 'category_id' => $categories->random()->id, 'isbn' => '9780140275360', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1800', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1388188509i/1371.jpg'],
            ['book_name' => 'Büyük Umutlar', 'author' => 'Charles Dickens', 'page_count' => 544, 'category_id' => $categories->random()->id, 'isbn' => '9780141439563', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1861', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327920219i/2623.jpg'],
            ['book_name' => 'Canterbury Hikayeleri', 'author' => 'Geoffrey Chaucer', 'page_count' => 504, 'category_id' => $categories->random()->id, 'isbn' => '9780140424386', 'publisher' => 'Yapı Kredi Yayınları', 'publish_year' => '1400', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1386920381i/2696.jpg'],
            ['book_name' => 'Moby Dick', 'author' => 'Herman Melville', 'page_count' => 720, 'category_id' => $categories->random()->id, 'isbn' => '9780142437247', 'publisher' => 'İş Bankası Kültür Yayınları', 'publish_year' => '1851', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1327940656i/153747.jpg'],
            ['book_name' => 'Gazap Üzümleri', 'author' => 'John Steinbeck', 'page_count' => 464, 'category_id' => $categories->random()->id, 'isbn' => '9780143039433', 'publisher' => 'Sel Yayıncılık', 'publish_year' => '1939', 'status' => 'available', 'book_cover' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1564084630i/4395.jpg']
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
