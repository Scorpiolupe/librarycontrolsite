<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class Books extends Seeder
{
    $books = [
        ['book_name' => '1984', 'author' => 'George Orwell', 'page_count' => 328, 'isbn' => '9780451524935', 'publisher' => 'Signet Classics', 'publish_year' => 1949, 'status' => 'Yayınlandı'],
        ['book_name' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'page_count' => 281, 'isbn' => '9780061120084', 'publisher' => 'HarperCollins', 'publish_year' => 1960, 'status' => 'Yayınlandı'],
        ['book_name' => 'Pride and Prejudice', 'author' => 'Jane Austen', 'page_count' => 279, 'isbn' => '9780141040349', 'publisher' => 'Penguin Classics', 'publish_year' => 1813, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'page_count' => 180, 'isbn' => '9780743273565', 'publisher' => 'Scribner', 'publish_year' => 1925, 'status' => 'Yayınlandı'],
        ['book_name' => 'Moby-Dick', 'author' => 'Herman Melville', 'page_count' => 585, 'isbn' => '9780142437247', 'publisher' => 'Penguin Classics', 'publish_year' => 1851, 'status' => 'Yayınlandı'],
        ['book_name' => 'War and Peace', 'author' => 'Leo Tolstoy', 'page_count' => 1225, 'isbn' => '9780199232765', 'publisher' => 'Oxford University Press', 'publish_year' => 1869, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Catcher in the Rye', 'author' => 'J.D. Salinger', 'page_count' => 277, 'isbn' => '9780316769488', 'publisher' => 'Little, Brown and Company', 'publish_year' => 1951, 'status' => 'Yayınlandı'],
        ['book_name' => 'Brave New World', 'author' => 'Aldous Huxley', 'page_count' => 268, 'isbn' => '9780060850524', 'publisher' => 'Harper Perennial Modern Classics', 'publish_year' => 1932, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Hobbit', 'author' => 'J.R.R. Tolkien', 'page_count' => 310, 'isbn' => '9780261103344', 'publisher' => 'HarperCollins', 'publish_year' => 1937, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Lord of the Rings', 'author' => 'J.R.R. Tolkien', 'page_count' => 1178, 'isbn' => '9780618640157', 'publisher' => 'Houghton Mifflin', 'publish_year' => 1954, 'status' => 'Yayınlandı'],
        ['book_name' => 'Catch-22', 'author' => 'Joseph Heller', 'page_count' => 453, 'isbn' => '9781451626650', 'publisher' => 'Simon & Schuster', 'publish_year' => 1961, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Odyssey', 'author' => 'Homer', 'page_count' => 560, 'isbn' => '9780140268867', 'publisher' => 'Penguin Classics', 'publish_year' => -800, 'status' => 'Yayınlandı'],
        ['book_name' => 'Ulysses', 'author' => 'James Joyce', 'page_count' => 732, 'isbn' => '9780141182803', 'publisher' => 'Penguin Classics', 'publish_year' => 1922, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Brothers Karamazov', 'author' => 'Fyodor Dostoevsky', 'page_count' => 796, 'isbn' => '9780374528379', 'publisher' => 'Farrar, Straus and Giroux', 'publish_year' => 1880, 'status' => 'Yayınlandı'],
        ['book_name' => 'Crime and Punishment', 'author' => 'Fyodor Dostoevsky', 'page_count' => 430, 'isbn' => '9780140449136', 'publisher' => 'Penguin Classics', 'publish_year' => 1866, 'status' => 'Yayınlandı'],
        ['book_name' => 'Anna Karenina', 'author' => 'Leo Tolstoy', 'page_count' => 864, 'isbn' => '9780143035008', 'publisher' => 'Penguin Classics', 'publish_year' => 1877, 'status' => 'Yayınlandı'],
        ['book_name' => 'Les Misérables', 'author' => 'Victor Hugo', 'page_count' => 1463, 'isbn' => '9780451419439', 'publisher' => 'Penguin Classics', 'publish_year' => 1862, 'status' => 'Yayınlandı'],
        ['book_name' => 'Don Quixote', 'author' => 'Miguel de Cervantes', 'page_count' => 1056, 'isbn' => '9780060934347', 'publisher' => 'Harper Perennial Modern Classics', 'publish_year' => 1605, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Divine Comedy', 'author' => 'Dante Alighieri', 'page_count' => 798, 'isbn' => '9780142437223', 'publisher' => 'Penguin Classics', 'publish_year' => 1320, 'status' => 'Yayınlandı'],
        ['book_name' => 'Frankenstein', 'author' => 'Mary Shelley', 'page_count' => 280, 'isbn' => '9780486282114', 'publisher' => 'Dover Publications', 'publish_year' => 1818, 'status' => 'Yayınlandı'],
        ['book_name' => 'Dracula', 'author' => 'Bram Stoker', 'page_count' => 488, 'isbn' => '9780141439846', 'publisher' => 'Penguin Classics', 'publish_year' => 1897, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Picture of Dorian Gray', 'author' => 'Oscar Wilde', 'page_count' => 254, 'isbn' => '9780141439570', 'publisher' => 'Penguin Classics', 'publish_year' => 1890, 'status' => 'Yayınlandı'],
        ['book_name' => 'The Call of the Wild', 'author' => 'Jack London', 'page_count' => 234, 'isbn' => '9780451530968', 'publisher' => 'Signet Classics', 'publish_year' => 1903, 'status' => 'Yayınlandı'],
        // 50'ye kadar bu şekilde devam edebilirsiniz...
    ];

    $categories = Category::all();  // Tüm kategorileri alıyoruz

    foreach ($books as $book) {
        // Kitapları kategorilerle ilişkilendirerek ekliyoruz
        Book::create([
            'book_name' => $book['book_name'],
            'author' => $book['author'],
            'page_count' => $book['page_count'],
            'category_id' => $categories->random()->id, // Rastgele kategori ataması
            'isbn' => $book['isbn'],
            'publisher' => $book['publisher'],
            'publish_year' => $book['publish_year'],
            'status' => $book['status'],
        ]);
    }
}
