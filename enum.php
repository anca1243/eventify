<?php

abstract class Enum
{
    final public function __construct($value)
    {
        $c = new ReflectionClass($this);
        if(!in_array($value, $c->getConstants())) {
            throw IllegalArgumentException();
        }
        $this->value = $value;
    }

    final public function __toString()
    {
        return $this->value;
    }
}


class Cities extends Enum {
  // If no value is given during object construction this value is used
  const __default = 1;
  // Our enum values
  const MANCHESTER     = "71409503111";
  const LIVERPOOL      = "110332012350598";
}

function getCity($a) {
  if ($a == Cities::MANCHESTER) return "Manchester";
  else if ($a == Cities::LIVERPOOL) return "Liverpool";
  else return "";
}
?>
