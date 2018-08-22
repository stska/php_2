<?php
/**
 * Created by PhpStorm.
 * User: Stas
 * Date: 20.08.2018
 * Time: 23:08
 */

//1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п

class Furniture {
    public $name;
    public $type;
    public $cost;

    function __construct($name,$type,$cost){
          $this->name=$name;
          $this->type=$type;
          $this->cost=$cost;
    }

    function formDetails (){
       $formName='<h3 style="margin: 5px ">'. $this -> name .'</h3>';
       $formType='<span>'. $this -> type .'</span>';
       $formCost='<span>'. $this -> cost .'</span>';

       return $formName.'<br>'.'Type: '.$formType.'<br>'.'Cost: '.$formCost.'<br>';
    }
    function formMain (){
        echo '<div style="width:250px; height:150px;margin: 50px auto;">'. $this->formDetails().'</div>';
    }
}

$turnOn= new Furniture("Creamy Peach","Table",10000);
$turnOn-> formMain();

//-----------------------------------Описать свойства класса из п.1 (состояние).
/*
var или public, как в моем случае, что является эквивалентом с php 5. Я описал три свойства name,type и cost класса Furniture.
Так как эти свойства являются public, то они доступны внутри класса, в его потомках а также из любомого места программы с использованием this.

-------------------------------------3. Описать поведение класса из п.1 (методы).

В классе Furniture имеется констуктор-метод __construct, для инициализации свойств класса, а также два метода formMain и formDetails. В моих методах все скушно,
происходит конкатенация синтаксиса html и свойств класса name, type и cost и доступ к которым осуществляется через this так как public, что означает что эти свойства
существуют в конткесте класса, а не объекта.

*/
//----------------------------------4. Придумать наследников класса из п.1. Чем они будут отличаться?
// Отличие, что это также мебель, но эксклюзивная, этого классу нужно все из родительского, цена, название,тип, плюс свои особеннолсти.
// Может сами св-ва надуманны, но идея вроде ясна)

class LuxuryFurniture extends Furniture {
            private $usedRareMaterial;
            private $brand;
            const bonusIfBought=5;


            function  __construct($name, $type, $cost,$usedRareMaterial,$brand)
            {
                parent::__construct($name, $type, $cost);
                $this->usedRareMaterial=$usedRareMaterial;
                $this->brand=$brand;
            }

            function addStatement(){
                 echo parent::formMain().'<br>'.'<div style="width:250px; height:150px;margin: -130px auto;">'.'Made of rare: '. $this-> usedRareMaterial .'<br>'.'From famous brand: '.  $this-> brand.'<br>'. 'Your discount is: '. self::bonusIfBought.'%'.'</div>'.'<br>';
            }
}

$lux=new LuxuryFurniture("San Monmar","Chair",100000,"Red wood","Versace");
$lux->addStatement();
//------------------------------------------

//5. Дан код:  Что он выведет на каждом шаге? Почему?
/*
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
$a1 = new A(); //создаем новый экземпляр класса A с именем $a1 используя дерективу new
$a2 = new A(); //создаем новый экземпляр класса A с именем $a2 используя дерективу new
$a1->foo();    //1
$a2->foo();    //2
$a1->foo();    //3
$a2->foo();    //4

1234
Так как при использовании ключевого слова static для определения локальной переменной мы получаем, что
 присваивание выполняется только одни раз, в самом начале при вызове функции. При завершении функции
значение остается и при новом вызове, переменная получает сохраненное значение.


---------------------------------------------------------------- /
Немного изменим п.5:  Объясните результаты в этом случае.
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {
}
$a1 = new A(); //создаем новый экземпляр класса A с именем $a1 используя дерективу new
$b1 = new B(); //создаем новый экземпляр дочернего класса B с именем $b 1 используя дерективу new
$a1->foo();   1
$b1->foo();    1
$a1->foo();    2
$b1->foo();     2

1122
$b1 начинается с 1, т.к при наследовании создается новый метод. Соответственно у нас есть два новых метода,
который живут своей жинью, в момент обращения к ним.

--------------------------------------------------------

Не понимаю, что нужно сделать еще, если в предыдущем вроде бы все указано)
7. *Дан код:
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {
}
$a1 = new A;
$b1 = new B;
$a1->foo();
$b1->foo();
$a1->foo();
$b1->foo();
Что он выведет на каждом шаге? Почему?
 */