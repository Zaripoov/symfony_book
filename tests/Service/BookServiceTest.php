<?php

namespace App\Tests\Service;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Exception\BookCategoryNotFoundException;
use App\Model\BookListItem;
use App\Model\BookListResponse;
use App\Repository\BookCategoryRepository;
use App\Repository\BookRepository;
use App\Service\BookService;
use App\Tests\AbstractTestCase;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

class BookServiceTest extends AbstractTestCase
{
    public function testGetBooksByCategoryNotFound(): void
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository->expects($this->once())
            ->method('find')
            ->with(130)
            ->willThrowException(new BookCategoryNotFoundException());

        $this->expectException(BookCategoryNotFoundException::class);

        (new BookService($bookRepository, $bookCategoryRepository))->getBooksByCategory(130);
    }

    public function testGetBooksByCategory()
    {
        $bookRepository = $this->createMock(BookRepository::class);
        $bookRepository->expects($this->once())
            ->method('findBooksByCategoryId')
            ->with(130)
            ->willReturn([$this->createBookEntity()]);

        $bookCategoryRepository = $this->createMock(BookCategoryRepository::class);
        $bookCategoryRepository->expects($this->once())
            ->method('find')
            ->with(130)
            ->willReturn(new BookCategory());

        $service = new BookService($bookRepository, $bookCategoryRepository);
        $excepted = new BookListResponse(items: [$this->createBookItemModel()]);

        $this->assertEquals($excepted, $service->getBooksByCategory(130));
    }

    private function createBookEntity(): Book
    {
        $book = (new Book())
            ->setTitle('Test book')
            ->setSlug('test-book')
            ->setMeap(false)
            ->setAuthors(['author'])
            ->setImage('http://localhost:8080/test.php')
            ->setCategories(new ArrayCollection())
            ->setPublicationDate(new DateTime('2020-10-10'));

        $this->setEntityId($book, 123);

        return $book;
    }

    private function createBookItemModel(): BookListItem
    {
        return (new BookListItem())
            ->setId(123)
            ->setTitle('Test book')
            ->setSlug('test-book')
            ->setMeap(false)
            ->setAuthors(['author'])
            //->setImage('http://localhost:8080/test.php')
            ->setPublicationDate(1602288000);

    }
}
