<?php
use PHPUnit\Framework\TestCase;

class FormValidationTest extends TestCase
{

    public $suitable_get = '{
        "name":"Krzysztof",
        "surname":"Cholewa",
        "country":"Polska",
        "street":"Polna",
        "house_number":"2P/2",
        "zip_code":"34-098",
        "city":"Jełowa",
        "phone":"785247771",
        "deliver_type":"Paczkomat",
        "payment_type":"PayU",
        "discount_code":"",
        "total":12599,
        "comment":""}';

    /**
     * @runInSeparateProcess
     */
     public function testShouldBeTrue(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';
         $this->assertTrue(valid_data($data));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseName(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->name="";
         $this->assertFalse(valid_data($data));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseSurname(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->surname="";
         $this->assertFalse(valid_data($data));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseCountry(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->country="England";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseStreet(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->street="Lorem ipsum dolor sit amet viverra fusce.";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeTrueZipCode(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->zip_code="45-123";
         $this->assertTrue(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseZipCode(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->zip_code="a-123";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalsePhone(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->phone="qbc123569";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseDeliverType(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->deliver_type="";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalsePaymentType(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->payment_type="";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseTotal(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->total="";
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseTotal2(){
        $_GET["data"] = $this->suitable_get; 
        $_GET["test"] = true;

        require './../send_order.php';

        $data->total=1.4;
         $this->assertFalse(valid_data($data));
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldBeFalseComment(){
        $_GET["data"] = $this->suitable_get;
        $_GET["test"] = true;

        require './../send_order.php';

        $data->comment="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas eget nisl nec nibh euismod accumsan. Integer vehicula convallis vehicula. Nam at nulla ipsum. Suspendisse eu viverra sem. Vestibulum enim dui, vehicula non purus vel, eleifend volutpat. ";
         $this->assertFalse(valid_data($data));
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldConnect(){
        $_GET["data"] = $this->suitable_get;
        $_GET["test"] = true;
        require './../send_order.php';

        $this->assertEquals(connect("localhost","root","","checkout")->error,null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldGenCode(){
        $_GET["data"] = $this->suitable_get;

        require './../send_order.php';
        $conn = connect("localhost","root","","checkout");
        $order_code = gen_code($conn);
        
        $this->assertIsString($order_code);
    }
    /**
     * @runInSeparateProcess
     */
    public function testShouldGenCodeLength(){
        $_GET["data"] = $this->suitable_get;

        require './../send_order.php';
        $conn = connect("localhost","root","","checkout");
        $order_code = gen_code($conn);
        
        $this->assertEquals(strlen($order_code),12);
    }

    /**
     * @runInSeparateProcess
     */
    public function testShouldAddToBase(){
        $_GET["data"] = $this->suitable_get;

        require './../send_order.php';
        $conn = connect("localhost","root","","checkout");
        $order_code = gen_code($conn);
        $result = send_query($data,$conn,$order_code);
        
        $this->assertTrue($result);
    }

}