<?php namespace App;

use Illuminate\Database\Eloquent\Model;


class bbStock extends Model {

	//
    protected $table = 'bbStock';
    protected $fillable = ['bbcode', 'bbname', 'po', 'style', 'color', 'size', 'qty', 'numofbb', 'location'];

    //protected $dates = ['$published_at'];

    public function scopeSearchpo($query, $po)
    {
        //return $query->where('po', 'LIKE', $po);
        return $query->where('po', '=', $po);
        // return $query->where([['po', '=', $po],['status', '=', 'STOCK']]);

    }

    public function scopeSearchsize($query, $size)
    {   

        return $query->where('size', '=', $size);
        // return $query->where([['size', '=', $size],['status', '=', 'STOCK']]);
    }


    public function scopemoreqtythan200 ($query) {

    	$query->where('qty', '>=', 200);
    }
    

}
