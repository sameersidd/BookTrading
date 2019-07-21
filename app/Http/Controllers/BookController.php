<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Book;
use App\TradeOffer;
use Symfony\Component\HttpFoundation\File\File;

class BookController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Book $book)
    {
        return view('books/view')->with('book', $book);
    }

    public function add()
    {
        $data = request()->validate([
            'name' => 'required',
            'author' => '',
            'img' => 'image'
        ]);

        if (request()->hasFile('img')) {
            $filename = date('Y_m_d_U') . request('img')->getClientOriginalName();
            $path = request('img')->storeAs('public/books', $filename);
            $data = array_merge(
                $data,
                ['img' => $path]
            );
        }

        auth()->user()->books()->create([
            'BookName' => $data['name'],
            'Author'   => $data['author'],
            'Cover_Image' => $data['img']
        ]);

        return redirect('home')->with('success', 'Added Successfully');
    }

    public function addPage()
    {
        return view('books/add');
    }

    public function editPage(Book $book)
    {
        $this->authorize('update', $book);
        return view('books/edit')->with('book', $book);
    }

    public function update(Book $book)
    {
        $this->authorize('update', $book);

        $data = request()->validate([
            $data = request()->validate([
                'name' => 'required',
                'author' => '',
                'img' => 'image'
            ])
        ]);

        if (request()->hasFile('img')) {
            $filename = date('Y_m_d_U') . request('img')->getClientOriginalName();
            $path = request('img')->storeAs('public/books', $filename);
            $data = array_merge(
                $data,
                ['img' => $path]
            );
        }
        $book->update([
            'BookName' => $data['name'],
            'Author'   => $data['author'],
            'Cover_Image' => $data['img']
        ]);

        return redirect('home')->with('success', 'Updated Successfully');
    }

    public function tradePage()
    {
        return view('books/trade');
    }

    public function delete($id)
    {
        $book = Book::find($id);
        $this->authorize('delete', $book);

        DB::transaction(function ($book, $id) {
            $trade = TradeOffer::where('trading_book_id', $id)->orWhere('for_book_id', $id)->first();

            if ($trade !== null)
                $trade->destroy();

            $book->destroy();
        }, 2);

        return redirect('home');
    }
}
