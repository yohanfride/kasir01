<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class item{
    private $name;
    private $price;
    private $qty;
    private $total;
    private $dollarSign;

    public function __construct($name = '', $price = 0, $qty=0, $dollarSign = false)
    {
        $this->name = $name;
        $this->price = $price;
        $this->qty = $qty;
        $this->dollarSign = $dollarSign;
        $this->total = $qty * $price;
    }

    public function getAsString($width = 48){
        
        $leftCols = $width - 2;
        $left = str_pad($this->name, $leftCols);
        
        $rightCols = 12;
        $leftCols2 = $width - $rightCols;
        if ($this->dollarSign) {
            $leftCols2 = $leftCols / 2 - $rightCols / 2;
        }
        $price = number_format($this->price,0,'.',','); 
        $sign = ($this->dollarSign ? 'Rp. ' : '');
        $left2 = str_pad($this->qty.' x '.$sign.$price, $leftCols2);
        $total = number_format($this->total,0,'.',','); 

        $right = str_pad($sign.$total, $rightCols, ' ', STR_PAD_LEFT);
        return "$left\n$left2$right\n";
    }

    public function getAsString_old($width = 48)
    {
        $rightCols = 10;
        $leftCols = $width - $rightCols;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);

        $sign = ($this->dollarSign ? 'Rp. ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left2$right\n";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}

class item2{
    private $name;
    private $price;
    private $qty;
    private $rigthcol;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false, $rigthcol = 10)
    {
        $this->name = $name;
        $this->price = $price;
        $this->rigthcol = $rigthcol;
        $this->dollarSign = $dollarSign;
    }

    public function getAsString($width = 48, $double=false)
    {
        $rightCols = $this->rigthcol;
        $leftCols = $width - $rightCols;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        if($double)
            $leftCols = $leftCols / 2;
        if($double)
            $rightCols = $rightCols / 2;
        $left = str_pad($this->name, $leftCols);
        $sign = ($this->dollarSign ? 'Rp. ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }

    public function getAsStringLeft($width = 48,$double=false)
    {
        $rightCols = $this->rigthcol;
        $leftCols = $width - $rightCols;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);
        $sign = ($this->dollarSign ? 'Rp. ' : '');
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left";
    }

    public function getAsStringRight($width = 48,$pls=0,$space=false,$double=false)
    {
        $rightCols = $this->rigthcol + $pls;
        $leftCols = $width - $rightCols;
        if ($this->dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this->name, $leftCols);
        $sign = ($this->dollarSign ? 'Rp. ' : '');

        if($space)
            $rightCols = $width;
        if($double)
            $rightCols =  $rightCols / 2;
        $right = str_pad($sign . $this->price, $rightCols, ' ', STR_PAD_LEFT);
        return "$right";
    }

    public function __toString()
    {
        return $this->getAsString();
    }
}


