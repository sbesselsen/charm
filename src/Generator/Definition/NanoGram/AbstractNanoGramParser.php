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
                $sts[] = 19;
                $os[] = array('token');
                $o += 5;
                goto st19;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 20;
                $os[] = array('regex');
                $o += 5;
                goto st20;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 21;
                $os[] = array('chars');
                $o += 5;
                goto st21;
            }
            if (substr_compare($string, 'escaped', $o, 7) === 0) {
                $sts[] = 18;
                $os[] = array('escaped');
                $o += 7;
                goto st18;
            }
            if (substr_compare($string, 'exact', $o, 5) === 0) {
                $sts[] = 17;
                $os[] = array('exact');
                $o += 5;
                goto st17;
            }
            if (substr_compare($string, 'operator', $o, 8) === 0) {
                $sts[] = 12;
                $os[] = array('operator');
                $o += 8;
                goto st12;
            }
            if (substr_compare($string, 'include', $o, 7) === 0) {
                $sts[] = 14;
                $os[] = array('include');
                $o += 7;
                goto st14;
            }
            if (substr_compare($string, 'whitespace', $o, 10) === 0) {
                $sts[] = 15;
                $os[] = array('whitespace');
                $o += 10;
                goto st15;
            }
            if (preg_match('(;[^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 6;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st6;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 13;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect COMMENT (;[^\\n]*), operator, NAME ([a-zA-Z_][a-zA-Z_0-9]*), include, whitespace, exact, escaped, token, regex or chars at line ' . $el . ', column ' . $ec);
        st1:
        if ($o === $l) {
            $r0 = array_pop($os);
            return $this->reduceGrammar($r0);
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $sts[] = 22;
                $os[] = array('
');
                $o += 1;
                goto st22;
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
        st9:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt2;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt2;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st10:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt2;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt2;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st11:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt2;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt2;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st12:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 23;
                $os[] = array(' ');
                $o += 1;
                goto st23;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st13:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 24;
                $os[] = array(' ');
                $o += 1;
                goto st24;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st14:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 25;
                $os[] = array(' ');
                $o += 1;
                goto st25;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st15:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 26;
                $os[] = array(' ');
                $o += 1;
                goto st26;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st16:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 27;
                $os[] = array(' ');
                $o += 1;
                goto st27;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st17:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 28;
                $os[] = array(' ');
                $o += 1;
                goto st28;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st18:
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
        st19:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st20:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st21:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st22:
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
                $sts[] = 19;
                $os[] = array('token');
                $o += 5;
                goto st19;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 20;
                $os[] = array('regex');
                $o += 5;
                goto st20;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 21;
                $os[] = array('chars');
                $o += 5;
                goto st21;
            }
            if (substr_compare($string, 'escaped', $o, 7) === 0) {
                $sts[] = 18;
                $os[] = array('escaped');
                $o += 7;
                goto st18;
            }
            if (substr_compare($string, 'exact', $o, 5) === 0) {
                $sts[] = 17;
                $os[] = array('exact');
                $o += 5;
                goto st17;
            }
            if (substr_compare($string, 'operator', $o, 8) === 0) {
                $sts[] = 12;
                $os[] = array('operator');
                $o += 8;
                goto st12;
            }
            if (substr_compare($string, 'include', $o, 7) === 0) {
                $sts[] = 14;
                $os[] = array('include');
                $o += 7;
                goto st14;
            }
            if (substr_compare($string, 'whitespace', $o, 10) === 0) {
                $sts[] = 15;
                $os[] = array('whitespace');
                $o += 10;
                goto st15;
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
                $sts[] = 13;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect COMMENT (;[^\\n]*), operator, NAME ([a-zA-Z_][a-zA-Z_0-9]*), include, whitespace, exact, escaped, token, regex, chars, end of string or \\n at line ' . $el . ', column ' . $ec);
        st23:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 31;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st31;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st24:
        if ($l > $o) {
            if (substr_compare($string, '->', $o, 2) === 0) {
                $sts[] = 32;
                $os[] = array('->');
                $o += 2;
                goto st32;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect -> at line ' . $el . ', column ' . $ec);
        st25:
        if ($l > $o) {
            if (preg_match('([^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 33;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st33;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ROL ([^\\n]*) at line ' . $el . ', column ' . $ec);
        st26:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 34;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st34;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st27:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 35;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st35;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st28:
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 19;
                $os[] = array('token');
                $o += 5;
                goto st19;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 20;
                $os[] = array('regex');
                $o += 5;
                goto st20;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 21;
                $os[] = array('chars');
                $o += 5;
                goto st21;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token, regex or chars at line ' . $el . ', column ' . $ec);
        st29:
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 19;
                $os[] = array('token');
                $o += 5;
                goto st19;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 20;
                $os[] = array('regex');
                $o += 5;
                goto st20;
            }
            if (substr_compare($string, 'chars', $o, 5) === 0) {
                $sts[] = 21;
                $os[] = array('chars');
                $o += 5;
                goto st21;
            }
            if (substr_compare($string, 'exact', $o, 5) === 0) {
                $sts[] = 17;
                $os[] = array('exact');
                $o += 5;
                goto st17;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect exact, token, regex or chars at line ' . $el . ', column ' . $ec);
        st30:
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
        st31:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 39;
                $os[] = array(' ');
                $o += 1;
                goto st39;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st32:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 40;
                $os[] = array(' ');
                $o += 1;
                goto st40;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st33:
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
        st34:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceWhitespaceDef($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt6;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceWhitespaceDef($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st35:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 41;
                $os[] = array(' ');
                $o += 1;
                goto st41;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st36:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceExactToken($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt8;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceExactToken($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt8;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st37:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceEscapedToken($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt9;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceEscapedToken($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt9;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st38:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceEscapedToken($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt9;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceEscapedToken($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt9;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st39:
        if ($l > $o) {
            if (preg_match('([0-9]+)ADs', $string, $m, 0, $o)) {
                $sts[] = 42;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st42;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect INTEGER ([0-9]+) at line ' . $el . ', column ' . $ec);
        st40:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 46;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st46;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st41:
        if ($l > $o) {
            if (preg_match('([^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 47;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st47;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ROL ([^\\n]*) at line ' . $el . ', column ' . $ec);
        st42:
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
                $sts[] = 48;
                $os[] = array(' ');
                $o += 1;
                goto st48;
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
        st43:
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
                $sts[] = 49;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st49;
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
        st44:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceArrayOf($r0);
            array_pop($sts);
            goto gt11;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt11;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt11;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st45:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceRuleRhs($r0);
            array_pop($sts);
            goto gt12;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhs($r0);
                array_pop($sts);
                goto gt12;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 50;
                $os[] = array(' ');
                $o += 1;
                goto st50;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleRhs($r0);
                array_pop($sts);
                goto gt12;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st46:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt13;
        }
        if ($l > $o) {
            if (preg_match('(\\n\\s*\\|)ADs', $string, $m, 0, $o)) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt13;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt13;
            }
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st47:
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
            goto gt7;
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
                goto gt7;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st48:
        if ($l > $o) {
            if (substr_compare($string, 'left', $o, 4) === 0) {
                $sts[] = 52;
                $os[] = array('left');
                $o += 4;
                goto st52;
            }
            if (substr_compare($string, 'right', $o, 5) === 0) {
                $sts[] = 53;
                $os[] = array('right');
                $o += 5;
                goto st53;
            }
            if (substr_compare($string, 'nonassoc', $o, 8) === 0) {
                $sts[] = 54;
                $os[] = array('nonassoc');
                $o += 8;
                goto st54;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect left, right or nonassoc at line ' . $el . ', column ' . $ec);
        st49:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 55;
                $os[] = array(' ');
                $o += 1;
                goto st55;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st50:
        if ($l > $o) {
            if (substr_compare($string, '{', $o, 1) === 0) {
                $sts[] = 56;
                $os[] = array('{');
                $o += 1;
                goto st56;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 57;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st57;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect { or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st51:
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
        st52:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt14;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt14;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st53:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt14;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt14;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st54:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt14;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt14;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st55:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 46;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st46;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st56:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 59;
                $os[] = array(' ');
                $o += 1;
                goto st59;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st57:
        if ($o === $l) {
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt13;
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
                goto gt13;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt13;
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
                goto gt13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st58:
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
            goto gt11;
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
                goto gt11;
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
                goto gt11;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st59:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 63;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st63;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 62;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st62;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) or EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st60:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 64;
                $os[] = array(' ');
                $o += 1;
                goto st64;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st61:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceCopyReduceAction($r0);
                array_pop($sts);
                goto gt15;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st62:
        if ($l > $o) {
            if (substr_compare($string, '(', $o, 1) === 0) {
                $sts[] = 65;
                $os[] = array('(');
                $o += 1;
                goto st65;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceCallReduceAction($r0);
                array_pop($sts);
                goto gt15;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ( or space at line ' . $el . ', column ' . $ec);
        st63:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt16;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt16;
            }
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt16;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, ) or , at line ' . $el . ', column ' . $ec);
        st64:
        if ($l > $o) {
            if (substr_compare($string, '}', $o, 1) === 0) {
                $sts[] = 66;
                $os[] = array('}');
                $o += 1;
                goto st66;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect } at line ' . $el . ', column ' . $ec);
        st65:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 63;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st63;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st66:
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
            goto gt12;
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
                goto gt12;
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
                goto gt12;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string, \\n or RULE_SPLIT (\\n\\s*\\|) at line ' . $el . ', column ' . $ec);
        st67:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $sts[] = 69;
                $os[] = array(')');
                $o += 1;
                goto st69;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $sts[] = 70;
                $os[] = array(',');
                $o += 1;
                goto st70;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        st68:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt17;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt17;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        st69:
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
                goto gt15;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st70:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 71;
                $os[] = array(' ');
                $o += 1;
                goto st71;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st71:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 63;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st63;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st72:
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
                goto gt17;
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
                goto gt17;
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
            case 22:
                $sts[] = 30;
                goto st30;
        }
        gt2:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 3;
                goto st3;
            case 22:
                $sts[] = 3;
                goto st3;
        }
        gt3:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 4;
                goto st4;
            case 22:
                $sts[] = 4;
                goto st4;
        }
        gt4:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 5;
                goto st5;
            case 22:
                $sts[] = 5;
                goto st5;
        }
        gt5:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 7;
                goto st7;
            case 22:
                $sts[] = 7;
                goto st7;
        }
        gt6:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 8;
                goto st8;
            case 22:
                $sts[] = 8;
                goto st8;
        }
        gt7:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 9;
                goto st9;
            case 22:
                $sts[] = 9;
                goto st9;
            case 28:
                $sts[] = 36;
                goto st36;
            case 29:
                $sts[] = 37;
                goto st37;
        }
        gt8:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 10;
                goto st10;
            case 22:
                $sts[] = 10;
                goto st10;
            case 29:
                $sts[] = 38;
                goto st38;
        }
        gt9:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 11;
                goto st11;
            case 22:
                $sts[] = 11;
                goto st11;
        }
        gt10:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 16;
                goto st16;
            case 22:
                $sts[] = 16;
                goto st16;
            case 28:
                $sts[] = 16;
                goto st16;
            case 29:
                $sts[] = 16;
                goto st16;
        }
        gt11:
        switch ($sts[count($sts) - 1]) {
            case 40:
                $sts[] = 43;
                goto st43;
        }
        gt12:
        switch ($sts[count($sts) - 1]) {
            case 40:
                $sts[] = 44;
                goto st44;
            case 55:
                $sts[] = 58;
                goto st58;
        }
        gt13:
        switch ($sts[count($sts) - 1]) {
            case 40:
                $sts[] = 45;
                goto st45;
            case 55:
                $sts[] = 45;
                goto st45;
        }
        gt14:
        switch ($sts[count($sts) - 1]) {
            case 48:
                $sts[] = 51;
                goto st51;
        }
        gt15:
        switch ($sts[count($sts) - 1]) {
            case 59:
                $sts[] = 60;
                goto st60;
        }
        gt16:
        switch ($sts[count($sts) - 1]) {
            case 59:
                $sts[] = 61;
                goto st61;
            case 65:
                $sts[] = 68;
                goto st68;
            case 71:
                $sts[] = 72;
                goto st72;
        }
        gt17:
        switch ($sts[count($sts) - 1]) {
            case 65:
                $sts[] = 67;
                goto st67;
        }
    }
    protected abstract function reduceGrammar($p0);
    protected abstract function reduceItems($p0, $p1, $p2 = null);
    protected abstract function reduceArrayOf($p0);
    protected abstract function reduceIdentity($p0);
    protected abstract function reduceComment($p0);
    protected abstract function reduceTokenDef($p0, $p1, $p2, $p3, $p4);
    protected abstract function reduceExactToken($p0, $p1, $p2);
    protected abstract function reduceEscapedToken($p0, $p1, $p2);
    protected abstract function reduceWhitespaceDef($p0, $p1, $p2);
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