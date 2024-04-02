<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller {

    public function index()
    {
        $this->load->view('calculator/calculator_view');
    }

    public function calculate()
    {
        // Ambil data dari form
        $num1 = $this->input->post('num1');
        $num2 = $this->input->post('num2');
        $operator = $this->input->post('operator');

        // Proses perhitungan
        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = 'Error: Division by zero';
                }
                break;
            default:
                $result = 'Error: Invalid operator';
                break;
        }

        // Tampilkan hasil
        $data['result'] = $result;
        $this->load->view('calculator/calculator_view', $data);
    }

}
