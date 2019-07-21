<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeOffer extends Model
{
    public function from()
    {
        return $this->belongsTo(User::class, 'from_user_id', 'id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }

    public function tradingBook()
    {
        return $this->belongsTo(Book::class, 'trading_book_id', 'id');
    }

    public function forBook()
    {
        return $this->belongsTo(Book::class, 'for_book_id', 'id');
    }
}
