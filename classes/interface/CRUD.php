<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPInterface.php to edit this template
 */

/**
 *
 * @author Tadeu Maffeis
 */
interface CRUD {
    public function create();
    public function read();
    public function update();
    public function delete();
}
