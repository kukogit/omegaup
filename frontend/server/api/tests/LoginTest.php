<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

define('WHOAMI', 'API');
require_once '../../inc/bootstrap.php';
require_once '../Login.php';



class LoginTest extends PHPUnit_Framework_TestCase
{
    
    
    
    public function testValidLogin()
    {
        $_POST["username"] = "user";
        $_POST["password"] = "password";
        
        $loginApi = new Login();
        
        $cleanValue = $loginApi->ExecuteApi();
        
        
        $this->assertNotNull($cleanValue);        
        $this->assertArrayHasKey('auth_token', $cleanValue);                
        
    }
    
    
    public function testInvalidPassword()
    {
        $_POST["username"] = "user";
        $_POST["password"] = "badpass";
        
        $loginApi = new Login();
        
        try
        {        
            $cleanValue = $loginApi->ExecuteApi();
        }
        catch(ApiException $e)
        {
            $arr = $e->getArrayMessage();
            
            $this->assertNotNull($arr);
            $this->assertArrayHasKey('error', $arr);   
            $this->assertEquals("Username or password is wrong. Please check your credentials", $arr["error"]);            
        
            // All fine :)
            return;
        }
               
        $this->fail('Unexpected exception thrown.');        
    }
    
    
    public function testInvalidUser()
    {
        $_POST["username"] = "baduser";
        $_POST["password"] = "pass";
        
        $loginApi = new Login();
        
        try
        {        
            $cleanValue = $loginApi->ExecuteApi();
        }
        catch(ApiException $e)
        {
            $arr = $e->getArrayMessage();
            
            $this->assertNotNull($arr);
            $this->assertArrayHasKey('error', $arr);   
            $this->assertEquals("Username or password is wrong. Please check your credentials", $arr["error"]);            
        
            // All fine :)
            return;
        }
               
        $this->fail('Unexpected exception thrown.');        
    }
    
    public function testTwoValidLogins()
    {
        $_POST["username"] = "user";
        $_POST["password"] = "password";
        
        $loginApi = new Login();
        
        try
        {        
            $cleanValue = $loginApi->ExecuteApi();
        }
        catch(ApiException $e)
        {
            $msg = $e->getArrayMessage();
            
            $this->fail('Unexpected exception thrown.'. $msg["error"] );        
        }
        
        
        try
        {        
            $cleanValue = $loginApi->ExecuteApi();
        }
        catch(ApiException $e)
        {
            $msg = $e->getArrayMessage();
            
            $this->fail('Second login failed, it should be bypassed. ' . $msg["error"]);                                
        }
               
        return;
        
    }
}

?>