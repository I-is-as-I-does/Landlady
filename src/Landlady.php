<?php
/* This file is part of Landlady | SSITU | (c) 2021 I-is-as-I-does */
namespace SSITU\Landlady;

class Landlady
{

    private $protocol;
    private $host;
    private $subdomain;
    private $domain;

    private $hostLabel;
    private $hostUrl;

    private $domainLabel;
    private $domainUrl;

    private $forceHttps;
    private $forceWww;

    public function __construct(bool $forceHttps = false, bool $forceWww = false)
    {
        $this->forceHttps = $forceHttps;
        $this->forceWww = $forceWww;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            if (!isset($this->$name)) {
                return $this->$name();
            }
            return $this->$name;
        }
    }

    public function protocol()
    {
        if (!isset($this->protocol)) {
            $this->protocol = MiniJack::getProtocol($this->forceHttps, false);
        }
        return $this->protocol;
    }

    public function host()
    {
        if (!isset($this->host)) {
            $this->host = $_SERVER['SERVER_NAME'];
        }
        return $this->host;
    }

    public function subdomain()
    {
        if (!isset($this->subdomain)) {
            $this->subdomain = MiniJack\Web::extractSubDomain($this->host, false);
        }
        return $this->subdomain;
    }

    public function domain()
    {
        if (!isset($this->domain)) {
            $this->domain = $this->host;
            if (!empty($this->subdomain)) {
                $this->domain = str_replace($this->subdomain . '.', '', $this->domain);
            }
        }
        return $this->domain;

    }

    public function altHost(string $newSubdomain)
    {
        return $newSubdomain . '.' . $this->domain;
    }

    public function altHostLabel(string $newSubdomain, ?string $addPath = null)
    {
        $altHostLabel = $this->altHost($newSubdomain);
        if ($this->forceWww && $newSubdomain != 'www') {
            $altHostLabel = 'www.' . $altHostLabel;
        }
        if ($addPath) {
            return $altHostLabel . '/' . $addPath;
        }
        return $altHostLabel;
    }

    public function altHostUrl(string $newSubdomain, ?string $addPath = null)
    {

        return $this->protocol . '://' . $this->altHostLabel($newSubdomain, $addPath);

    }

    public function hostLabel(?string $addPath = null)
    {
        if (!isset($this->hostLabel)) {
            $this->hostLabel = $this->host;
            if ($this->forceWww && $this->subdomain != 'www') {
                $this->hostLabel = 'www.' . $this->hostLabel;
            }
        }
        if ($addPath) {
            return $this->hostLabel . '/' . $addPath;
        }
        return $this->hostLabel;
    }

    public function hostUrl(?string $addPath = null)
    {
        if (!isset($this->hostUrl)) {
            $this->hostUrl = $this->protocol . '://' . $this->hostLabel;
        }

        if ($addPath) {
            return $this->hostUrl . '/' . $addPath;
        }
        return $this->hostUrl;
    }

    public function domainLabel(?string $addPath = null)
    {
        if (!isset($this->domainLabel)) {
            $this->domainLabel = $this->domain;
            if ($this->forceWww) {
                $this->domainLabel = 'www.' . $this->domainLabel;
            }
        }
        if ($addPath) {
            return $this->domainLabel . '/' . $addPath;
        }
        return $this->domainLabel;
    }

    public function domainUrl(?string $addPath = null)
    {
        if (!isset($this->domainUrl)) {
            $this->domainUrl = $this->protocol . '://' . $this->domainLabel;
        }

        if ($addPath) {
            return $this->domainUrl . '/' . $addPath;
        }
        return $this->domainUrl;
    }
}
