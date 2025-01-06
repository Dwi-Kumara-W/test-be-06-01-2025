<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function responseFail($message, $errors = array(), $data = array()) {
    $response = [
        'status' => 'fail',
        'message' => $message,
        'errors' => $errors,
        'data' => $data
    ];

    return $response;
}

function responseSuccess($message, $data = array()) {
    $response = [
        'status' => "success",
        'message' => $message,
        'data' => $data
    ];

    return $response;
}

function responseDatatableSuccess($message, $data = array()) {
    $response = [
        'status' => "success",
        'message' => $message,
    ];
    $return = array_merge($response, $data);

    return $return;
}
