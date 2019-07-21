<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use App\Book;
use Illuminate\Support\Facades\DB;
use App\TradeOffer;

class TradeOfferController extends Controller
{
    public function create()
    {
        $req = request()->validate([
            'to' => 'required|exists:users',
            'trading_id' => 'required|exists:books',
            'for_id' => 'exists:books|nullable'
        ]);

        $from = auth()->user();
        $to = User::findorFail($req['to']);
        $trading = Book::findorFail($req['trading_id']);
        if ($req['for_id'])
            $for = Book::findorFail($req['for_id']);
        else $for = null;

        if ($to === null)
            return redirect()->back(400)->withErrors($to);
        else if ($trading === null)
            return redirect()->back(400)->withErrors($trading);

        DB::beginTransaction();
        $trade = new TradeOffer();
        $trade->from_user_id = $from->id;
        $trade->to_user_id = $to->id;
        $trade->trading_book_id = $trading;
        $trade->for_book_id = $for->id || $for;
        $trade->status = 'offered';
        $trade->save();
        $id = $trade->id;
        if (!$trade) {
            DB::rollBack();
            return redirect()->back(500)->withErrors($trade);
        } else {
            DB::commit();
        }
        return redirect('home', 200)->with('trade_id', $id);
    }

    public function view(TradeOffer $trade)
    {
        return view('trade')->with('trade', $trade);
    }

    public function update($id)
    {
        request()->validate([
            'tradeStatus' => 'required'
        ]);
        if (request('tradeStatus') == "accepted")
            $result = accepted($id);
        elseif (request('tradeStatus') == "declined")
            $result = declined($id);


        function accepted($id)
        {
            try {
                DB::beginTransaction();
                $trade = TradeOffer::find($id);
                $trading_book = Book::find($trade->trading_book_id);
                $trading_book->currentOwner_id = $trade->to_user_id;
                $trading_book->save();
                if ($trade->for_book_id !== null) {
                    $for_book = Book::find($trade->for_book_id);
                    $for_book->currentOwner_id = $trade->from_user_id;
                    $for_book->save();
                }
                if ($for_book && $trading_book) {
                    DB::commit();
                    $trade->status = 'accepted';
                    $trade->save();
                } else {
                    DB::rollBack();
                    throw new \Exception("Error. Transaction not successful", 500);
                }
            } catch (\Exception $e) {
                return redirect()->back(500)->withException($e);
            }

            return "Succesful!";
        }

        function declined($id)
        {
            $trade = TradeOffer::find($id);
            $trade->status = 'declined';
            $trade->save();

            return "Declined!";
        }

        return redirect('home')->with('tradeStatus', $result);
    }

    public function delete(TradeOffer $trade)
    {
        $trade->status = 'deleted';
        $trade->delete();
        return redirect()->back(200)->with('deleteStatus', "Success");
    }
}
