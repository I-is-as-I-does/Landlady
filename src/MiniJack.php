<?php
/* This file is part of Landlady | SSITU | (c) 2021 I-is-as-I-does */
namespace SSITU\MiniJack;
class Web
{

    public static function getProtocol($forceHttps = false, $addDelimiter = false)
    {
        $protoc = 'http';

        if ($forceHttps || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ||
            $_SERVER['SERVER_PORT'] == 443
        ) {
            $protoc .= 's';
        }
        if ($addDelimiter) {
            $protoc .= '://';
        }
        return $protoc;
    }

    public static function extractSubDomain(?string $url = null, bool $exlude_www = true)
    {
        //@doc: this method WILL exclude www
        if (empty($url)) {
            $url = $_SERVER['SERVER_NAME'];
        }
        $trimPattern = '^(https?)?([:\/])*';
        if ($exlude_www) {
            $trimPattern .= '(www\.)?';
        }
        $url = preg_replace('/' . $trimPattern . '/', '', $url);
        preg_match('/^([\w-]+)(?=\.[\w-]+\.)/', $url, $matches);
        if (!empty($matches)) {
            return $matches[0];
        }
        return '';
    }
}