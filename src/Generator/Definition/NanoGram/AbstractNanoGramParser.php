<?php

namespace Charm\Generator\Definition\NanoGram;

abstract class AbstractNanoGramParser
{
    public function parse(string $string)
    {
        $sts = array(0);
        $os = array();
        $o = 0;
        $l = strlen($string);
        goto st0;
        st0:
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 12;
                $os[] = array('token');
                $o += 5;
                goto st12;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 14;
                $os[] = array('regex');
                $o += 5;
                goto st14;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 15;
                $os[] = array('chars');
                $o += 5;
                goto st15;
            }
            if (substr_compare($string, 'escaped', $o, 7) === 0) {
                $sts[] = 13;
                $os[] = array('escaped');
                $o += 7;
                goto st13;
            }
            if (substr_compare($string, 'operator', $o, 8) === 0) {
                $sts[] = 9;
                $os[] = array('operator');
                $o += 8;
                goto st9;
            }
            if (substr_compare($string, 'include', $o, 7) === 0) {
                $sts[] = 11;
                $os[] = array('include');
                $o += 7;
                goto st11;
            }
            if (preg_match('(;[^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 6;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st6;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 10;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect COMMENT (;[^\\n]*), operator, NAME ([a-zA-Z_][a-zA-Z_0-9]*), include, token, escaped, regex or chars at line ' . $el . ', column ' . $ec);
        st1:
        if ($o === $l) {
            $r0 = array_pop($os);
            return $this->reduceGrammar($r0);
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $sts[] = 16;
                $os[] = array('
');
                $o += 1;
                goto st16;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect \\n or end of string at line ' . $el . ', column ' . $ec);
        st2:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceArrayOf($r0);
            array_pop($sts);
            goto gt0;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt0;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st3:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt1;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt1;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st4:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt1;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt1;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st5:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt1;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt1;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st6:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceComment($r0);
            array_pop($sts);
            goto gt1;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceComment($r0);
                array_pop($sts);
                goto gt1;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st7:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt1;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt1;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st8:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 17;
                $os[] = array(' ');
                $o += 1;
                goto st17;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st9:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 18;
                $os[] = array(' ');
                $o += 1;
                goto st18;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st10:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 19;
                $os[] = array(' ');
                $o += 1;
                goto st19;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st11:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 20;
                $os[] = array(' ');
                $o += 1;
                goto st20;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st12:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st13:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 21;
                $os[] = array(' ');
                $o += 1;
                goto st21;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st14:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st15:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st16:
        if ($o === $l) {
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceItems($r0, $r1);
            array_pop($sts);
            array_pop($sts);
            goto gt0;
        }
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 12;
                $os[] = array('token');
                $o += 5;
                goto st12;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 14;
                $os[] = array('regex');
                $o += 5;
                goto st14;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 15;
                $os[] = array('chars');
                $o += 5;
                goto st15;
            }
            if (substr_compare($string, 'escaped', $o, 7) === 0) {
                $sts[] = 13;
                $os[] = array('escaped');
                $o += 7;
                goto st13;
            }
            if (substr_compare($string, 'operator', $o, 8) === 0) {
                $sts[] = 9;
                $os[] = array('operator');
                $o += 8;
                goto st9;
            }
            if (substr_compare($string, 'include', $o, 7) === 0) {
                $sts[] = 11;
                $os[] = array('include');
                $o += 7;
                goto st11;
            }
            if (preg_match('(;[^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 6;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st6;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceItems($r0, $r1);
                array_pop($sts);
                array_pop($sts);
                goto gt0;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 10;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect COMMENT (;[^\\n]*), operator, NAME ([a-zA-Z_][a-zA-Z_0-9]*), include, token, escaped, regex, chars, end of string or \\n at line ' . $el . ', column ' . $ec);
        st17:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 23;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st23;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st18:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 24;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st24;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st19:
        if ($l > $o) {
            if (substr_compare($string, '->', $o, 2) === 0) {
                $sts[] = 25;
                $os[] = array('->');
                $o += 2;
                goto st25;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect -> at line ' . $el . ', column ' . $ec);
        st20:
        if ($l > $o) {
            if (preg_match('([^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 26;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st26;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ROL ([^\\n]*) at line ' . $el . ', column ' . $ec);
        st21:
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 27;
                $os[] = array('token');
                $o += 5;
                goto st27;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 28;
                $os[] = array('chars');
                $o += 5;
                goto st28;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token or chars at line ' . $el . ', column ' . $ec);
        st22:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceItems($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt0;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceItems($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt0;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st23:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 29;
                $os[] = array(' ');
                $o += 1;
                goto st29;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st24:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 30;
                $os[] = array(' ');
                $o += 1;
                goto st30;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st25:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 31;
                $os[] = array(' ');
                $o += 1;
                goto st31;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st26:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceInclude($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt5;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceInclude($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt5;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st27:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceEscapedTokenType($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st28:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceEscapedCharsType($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st29:
        if ($l > $o) {
            if (preg_match('([^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 32;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st32;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ROL ([^\\n]*) at line ' . $el . ', column ' . $ec);
        st30:
        if ($l > $o) {
            if (preg_match('([0-9]+)ADs', $string, $m, 0, $o)) {
                $sts[] = 33;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st33;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect INTEGER ([0-9]+) at line ' . $el . ', column ' . $ec);
        st31:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 37;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st37;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st32:
        if ($o === $l) {
            $r4 = array_pop($os);
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceTokenDef($r0, $r1, $r2, $r3, $r4);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt2;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceTokenDef($r0, $r1, $r2, $r3, $r4);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt2;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st33:
        if ($o === $l) {
            $r4 = array_pop($os);
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceOperatorDef($r0, $r1, $r2, $r3, $r4);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt3;
        }
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 38;
                $os[] = array(' ');
                $o += 1;
                goto st38;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceOperatorDef($r0, $r1, $r2, $r3, $r4);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt3;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string or \\n at line ' . $el . ', column ' . $ec);
        st34:
        if ($o === $l) {
            $r4 = array_pop($os);
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceRuleSet($r0, $r1, $r2, $r3, $r4);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt4;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $sts[] = 39;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st39;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleSet($r0, $r1, $r2, $r3, $r4);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt4;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect RULE_SPLIT (\\n\\s*\\|), end of string or \\n at line ' . $el . ', column ' . $ec);
        st35:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceArrayOf($r0);
            array_pop($sts);
            goto gt7;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt7;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt7;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st36:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceRuleRhs($r0);
            array_pop($sts);
            goto gt8;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhs($r0);
                array_pop($sts);
                goto gt8;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 40;
                $os[] = array(' ');
                $o += 1;
                goto st40;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhs($r0);
                array_pop($sts);
                goto gt8;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st37:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt9;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt9;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt9;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt9;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st38:
        if ($l > $o) {
            if (substr_compare($string, 'left', $o, 4) === 0) {
                $sts[] = 42;
                $os[] = array('left');
                $o += 4;
                goto st42;
            }
            if (substr_compare($string, 'right', $o, 5) === 0) {
                $sts[] = 43;
                $os[] = array('right');
                $o += 5;
                goto st43;
            }
            if (substr_compare($string, 'nonassoc', $o, 8) === 0) {
                $sts[] = 44;
                $os[] = array('nonassoc');
                $o += 8;
                goto st44;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect left, right or nonassoc at line ' . $el . ', column ' . $ec);
        st39:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 45;
                $os[] = array(' ');
                $o += 1;
                goto st45;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st40:
        if ($l > $o) {
            if (substr_compare($string, '{', $o, 1) === 0) {
                $sts[] = 46;
                $os[] = array('{');
                $o += 1;
                goto st46;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 47;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st47;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect { or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st41:
        if ($o === $l) {
            $r6 = array_pop($os);
            $r5 = array_pop($os);
            $r4 = array_pop($os);
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceOperatorDef($r0, $r1, $r2, $r3, $r4, $r5, $r6);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt3;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r6 = array_pop($os);
                $r5 = array_pop($os);
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceOperatorDef($r0, $r1, $r2, $r3, $r4, $r5, $r6);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt3;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st42:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt10;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st43:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt10;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st44:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt10;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st45:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 37;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st37;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st46:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 49;
                $os[] = array(' ');
                $o += 1;
                goto st49;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st47:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt9;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt9;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt9;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt9;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st48:
        if ($o === $l) {
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceRuleRhsList($r0, $r1, $r2, $r3);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt7;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhsList($r0, $r1, $r2, $r3);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt7;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhsList($r0, $r1, $r2, $r3);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt7;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st49:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 53;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st53;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 52;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st52;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) or EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st50:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 54;
                $os[] = array(' ');
                $o += 1;
                goto st54;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st51:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceCopyReduceAction($r0);
                array_pop($sts);
                goto gt11;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st52:
        if ($l > $o) {
            if (substr_compare($string, '(', $o, 1) === 0) {
                $sts[] = 55;
                $os[] = array('(');
                $o += 1;
                goto st55;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceCallReduceAction($r0);
                array_pop($sts);
                goto gt11;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ( or space at line ' . $el . ', column ' . $ec);
        st53:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt12;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt12;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt12;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, ) or , at line ' . $el . ', column ' . $ec);
        st54:
        if ($l > $o) {
            if (substr_compare($string, '}', $o, 1) === 0) {
                $sts[] = 56;
                $os[] = array('}');
                $o += 1;
                goto st56;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect } at line ' . $el . ', column ' . $ec);
        st55:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 53;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st53;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st56:
        if ($o === $l) {
            $r6 = array_pop($os);
            $r5 = array_pop($os);
            $r4 = array_pop($os);
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceRuleRhs($r0, $r1, $r2, $r3, $r4, $r5, $r6);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt8;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r6 = array_pop($os);
                $r5 = array_pop($os);
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhs($r0, $r1, $r2, $r3, $r4, $r5, $r6);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt8;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r6 = array_pop($os);
                $r5 = array_pop($os);
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhs($r0, $r1, $r2, $r3, $r4, $r5, $r6);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt8;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st57:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $sts[] = 59;
                $os[] = array(')');
                $o += 1;
                goto st59;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $sts[] = 60;
                $os[] = array(',');
                $o += 1;
                goto st60;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        st58:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt13;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        st59:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceCallReduceAction($r0, $r1, $r2, $r3);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt11;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st60:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 61;
                $os[] = array(' ');
                $o += 1;
                goto st61;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st61:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 53;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st53;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st62:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionArgs($r0, $r1, $r2, $r3);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt13;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionArgs($r0, $r1, $r2, $r3);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        gt0:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 1;
                goto st1;
        }
        gt1:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 2;
                goto st2;
            case 16:
                $sts[] = 22;
                goto st22;
        }
        gt2:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 3;
                goto st3;
            case 16:
                $sts[] = 3;
                goto st3;
        }
        gt3:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 4;
                goto st4;
            case 16:
                $sts[] = 4;
                goto st4;
        }
        gt4:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 5;
                goto st5;
            case 16:
                $sts[] = 5;
                goto st5;
        }
        gt5:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 7;
                goto st7;
            case 16:
                $sts[] = 7;
                goto st7;
        }
        gt6:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 8;
                goto st8;
            case 16:
                $sts[] = 8;
                goto st8;
        }
        gt7:
        switch ($sts[count($sts) - 1]) {
            case 31:
                $sts[] = 34;
                goto st34;
        }
        gt8:
        switch ($sts[count($sts) - 1]) {
            case 31:
                $sts[] = 35;
                goto st35;
            case 45:
                $sts[] = 48;
                goto st48;
        }
        gt9:
        switch ($sts[count($sts) - 1]) {
            case 31:
                $sts[] = 36;
                goto st36;
            case 45:
                $sts[] = 36;
                goto st36;
        }
        gt10:
        switch ($sts[count($sts) - 1]) {
            case 38:
                $sts[] = 41;
                goto st41;
        }
        gt11:
        switch ($sts[count($sts) - 1]) {
            case 49:
                $sts[] = 50;
                goto st50;
        }
        gt12:
        switch ($sts[count($sts) - 1]) {
            case 49:
                $sts[] = 51;
                goto st51;
            case 55:
                $sts[] = 58;
                goto st58;
            case 61:
                $sts[] = 62;
                goto st62;
        }
        gt13:
        switch ($sts[count($sts) - 1]) {
            case 55:
                $sts[] = 57;
                goto st57;
        }
    }
    protected abstract function reduceGrammar($p0);
    protected abstract function reduceItems($p0, $p1, $p2 = null);
    protected abstract function reduceArrayOf($p0);
    protected abstract function reduceIdentity($p0);
    protected abstract function reduceComment($p0);
    protected abstract function reduceTokenDef($p0, $p1, $p2, $p3, $p4);
    protected abstract function reduceEscapedTokenType($p0, $p1, $p2);
    protected abstract function reduceEscapedCharsType($p0, $p1, $p2);
    protected abstract function reduceOperatorDef($p0, $p1, $p2, $p3, $p4, $p5 = null, $p6 = null);
    protected abstract function reduceRuleSet($p0, $p1, $p2, $p3, $p4);
    protected abstract function reduceRuleRhsList($p0, $p1, $p2, $p3);
    protected abstract function reduceRuleRhs($p0, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null);
    protected abstract function reduceSequenceItems($p0, $p1, $p2);
    protected abstract function reduceCopyReduceAction($p0);
    protected abstract function reduceCallReduceAction($p0, $p1 = null, $p2 = null, $p3 = null);
    protected abstract function reduceReduceActionArgs($p0, $p1, $p2, $p3);
    protected abstract function reduceReduceActionPointer($p0);
    protected abstract function reduceInclude($p0, $p1, $p2);
}