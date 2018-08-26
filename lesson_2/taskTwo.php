<?php
/*
 * 1. Создать структуру классов ведения товарной номенклатуры.
а) Есть абстрактный товар.
б) Есть цифровой товар, штучный физический товар и товар на вес.
в) У каждого есть метод подсчета финальной стоимости.
г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза. У штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах. У всех формируется в конечном итоге доход с продаж.
д) Что можно вынести в абстрактный класс, наследование?
2. *Реализовать паттерн Singleton при помощи traits.
 */

abstract class  AbstractGoods
{

    abstract public function describe();                     //вывод информации он товаре

    abstract public function purchasing_price();   //вывод закупочной стоимости товара исходя из кол-ва;

    abstract public function setItem($name, $type, $counts, $costPurchising);      //задание параметров товара

    abstract public function setName($name);         // тоже самое но по отдельности

    abstract public function setType($type);

    abstract public function setCounts($counts);

}
//Общий класс для товаров
class Goods extends AbstractGoods
{
    private $name;
    private $type;
    private $counts;

    private $costPurchising;

    public function getCostPurchising()
    {
        return $this->costPurchising;
    }

    public function getCounts()
    {
        return $this->counts;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getType()
    {
        return $this->type;
    }


    public function setCostPurchising($costPurchising)
    {
        $this->costPurchising = $costPurchising;
    }

    public function setCounts($counts)
    {
        $this->counts = $counts;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setItem($name = 'empty', $type = 'empty', $counts = 'empty', $costPurchising = 'empty')
    {
        $this->name = $name;
        $this->type = $type;
        $this->counts = $counts;
        $this->costPurchising = $costPurchising;
    }


    public function describe()                  //вывод информации о товаре (название,тип,стоимость);
    {
        return '| Name: ' . Goods::getName() . '<br>' . '| Type: ' . Goods::getType() . '<br>' . '| Counts: ' . $this->getCounts() . '<br>';

    }

    public function purchasing_price()
    {          //показ закупочный цены и расчет стоимости товара изходя из кол-ва по закупочной цене.

        return (self::getCounts() / 1000) * self::getCostPurchising();

    }


}

//Цифровой това
class Digital extends Goods
{
    private $cost = (Piece_goods::cost) / 2;
    private $counts;

    private $purchising_price = (Piece_goods::purchising_price) / 2;


    public function getCounts()
    {
        return $this->counts;
    }

    public function setCounts($counts)
    {
        $this->counts = $counts;
    }
    //цена в зависимости от веса
    function summ()
    {

        return self::getCounts() * $this->cost . '<br>';
    }
    //закупочная цена
    function primary_sum()
    {
        return self::getCounts() * $this->purchising_price . '<br>';
    }

}

//Штучный товар
class Piece_goods extends Goods
{

    const purchising_price = 50;
    const cost = self::purchising_price * 2;
    private $counts;

    public function getCounts()
    {
        return $this->counts;
    }

    public function setCounts($counts)
    {
        $this->counts = $counts;
    }
    //цена в зависимости от веса
    public function summ()
    {
        return self::getCounts() * self::cost . '<br>';
    }
    //закупочная цена
    function primary_sum()
    {
        return self::purchising_price * self::getCounts() . '<br>';
    }

}

//Товар на вес.
class Weight_product extends Goods
{
    const cost = 1000;         //за 1 кг
    const purchising_cost = 200; //закупочная за 1кг
    private $counts;


    public function getCounts()
    {
        return $this->counts . '<br>';
    }

    public function setCounts($counts)
    {
        $this->counts = $counts;
    }

    //цена в зависимости от веса
    public function weight()
    {

        return self::cost * (self::getCounts() / 1000);

    }
    //закупочная цена
    function primary_sum()
    {
        return (self::purchising_cost * self::getCounts() / 1000);
    }

}
//доход,грубо
class Net_profit extends Goods
{
    public $sum = 0;
    use Singleton;

}
//не знаю есть ли смысл в использования этого в таком ключе
trait Singleton{
    protected static $summ;
    protected static $summ2;

    protected function __construct()
    {
        static::setInstance_1($this);
        static::setInstance_2($this);
    }
    final public static function setInstance_1($summ){
        return static::$summ=$summ;
    }
    final public static function setInstance_2($summ2){
        return static::$summ2=$summ2;
    }
    final public static function getInstance_1(){
        return isset(static::$summ)? static::$summ : static::$summ= new static;
    }
    final public static function getInstance_2(){
        return isset(static::$summ2)? static::$summ2 : static::$summ2= new static;
    }
     public static function finalSum(){
        return static::getInstance_1() - static::getInstance_2();
    }

}

//Цифровой товар
$try = new Goods();
$try->setName('Song');
$try->setType('Music');
$try->setCounts(2);
$try_cost = new Digital();
$try_cost->setCounts($try->getCounts()); // как автоматизировать этот моменти уже в классе, подскажите.
echo $try->describe() . '| Cost: ' . $try_cost->summ() . '| Purchasing price: ' . $try_cost->primary_sum();    //оказалось, что не очен удачно организована структура у меня. т.к если я выношу <html> теги туда, то не будут считаться данные так как смешиваются численные и текстовые переменные.
//как можно организовать это все короче и более структурированно?
$tryCost = Net_profit::setInstance_1($try_cost->summ());
$tryCost = Net_profit::setInstance_2($try_cost->primary_sum());
$tryCost=Net_profit::finalSum();

echo ' | Profit: ' .@$tryCost. '<br>';

//Товар на вес
$next = new Goods();
$next->setItem('Gala', 'Apples', 50);
$nextSum = new Weight_product();
$nextSum->setCounts($next->getCounts());
echo  '<br>'.$next->describe() . '| Cost: ' . $nextSum->weight() . '<br>' . '| Purchasing price: ' . $nextSum->primary_sum();
//грубо доход

$profit = Net_profit::setInstance_1($nextSum->weight());
$profit = Net_profit::setInstance_2($nextSum->primary_sum());
$profit=Net_profit::finalSum();
echo '<br>' . ' | Profit: ' .@$profit. '<br>';

//Штукчный товар.
$pieces = new Goods();
$pieces->setItem('Pepsi', 'Beverage', 1);
$buyPieces = new Piece_goods();
$buyPieces->setCounts($pieces->getCounts());
echo '<br>' . $pieces->describe() . '| Cost: ' . $buyPieces->summ()  . '| Purchasing price: ' . $buyPieces->primary_sum();
//грубо доход
$piecesProfit = Net_profit::setInstance_1($buyPieces->summ());
$piecesProfit = Net_profit::setInstance_2($buyPieces->primary_sum());
$piecesProfit=Net_profit::finalSum();

echo ' | Profit: ' .@$piecesProfit. '<br>';





