<?php

namespace Drupal\album;



class HelloService{

  private $sayHello="Hello World!";

  /**
   * @return mixed
   */
  public function sayHello()
  {
    return $this->sayHello;
  }

}



