<?php

namespace MyTeto;

class TestCLIApp extends \MyTeto\CLI
{
    public function normal_cmd()
    {
        return 'success!';
    }

    /**
     * @throws \OutOfRangeException
     */
    public function get_raise_outofrange()
    {
        return $this->not_exists;
    }

    /**
     * @throws \OutOfRangeException
     */
    public function set_raise_outofrange()
    {
        $this->not_exists = 'value';
    }

    private function private_cmd_is_invisible()
    {
        return "Don't returns!";
    }
}

class CLITest extends \MyTeto\TestCase
{
    public function test_normal_cmd()
    {
        $expected = 'success!';
        $arg = array('testappcmd', 'normal_cmd');
        $cli = new TestCLIApp($arg);

        $actual = $cli->__invoke();
        $this->assertSame($expected, $actual);
    }

    public function test_get_raise_OutOuRangeException()
    {
        $arg = array('testappcmd', 'get_raise_outofrange');
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('OutOfRangeException');
        $cli->__invoke();
    }

    public function test_set_raise_OutOuRangeException()
    {
        $arg = array('testappcmd', 'set_raise_outofrange');
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('OutOfRangeException');
        $cli->__invoke();
    }

    public function test_privateMethod_raise_RuntimeException()
    {
        $arg = array('testappcmd', 'private_cmd_is_invisible');
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('RuntimeException');
        $cli->__invoke();
    }

    public function test_protectedMethod_raise_RuntimeException()
    {
        $arg = array('testappcmd', 'protected_cmd_is_invisible');
        $cli = new TestCLIApp($arg);

        $this->setExpectedException('RuntimeException');
        $cli->__invoke();
    }
}
