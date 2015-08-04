<?php
class Car
{
    private $make_model;
    private $price;
    private $miles;
    private $image_path;

    function setMake($new_make)
    {
        $this->make_model = (string) $new_make;
    }
    function getMake()
    {
        return $this->make_model;
    }
    function setPrice($new_price)
    {
        $this->price = (int) $new_price;
    }
    function getPrice()
    {
        return $this->price;
    }
    function setMiles($new_miles)
    {
        $this->miles = (int) $new_miles;
    }
    function getMiles()
    {
        return $this->miles;
    }
    function setImagePath($new_image_path)
    {
        $this->image_path = (string) $new_image_path;
    }
    function getImagePath()
    {
        return $this->image_path;
    }
    function worthBuying($max_price, $max_miles)
    {
        return (($this->price <= $max_price) && ($this->miles <= $max_miles));
    }
    function __construct($car_make_model, $car_price, $car_miles, $car_image_path)
    {
        $this->make_model = $car_make_model;
        $this->price = $car_price;
        $this->miles = $car_miles;
        $this->image_path = $car_image_path;
    }
}
