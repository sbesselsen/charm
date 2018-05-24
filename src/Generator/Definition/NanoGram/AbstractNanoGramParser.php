<?php

namespace Chompy\Generator\Definition\NanoGram;

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
                $sts[] = 1;
                $os[] = array('token');
                $o += 5;
                goto st1;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 2;
                $os[] = array('regex');
                $o += 5;
                goto st2;
            }
            if (substr_compare($string, 'escaped', $o, 7) === 0) {
                $sts[] = 3;
                $os[] = array('escaped');
                $o += 7;
                goto st3;
            }
            if (substr_compare($string, 'operator', $o, 8) === 0) {
                $sts[] = 4;
                $os[] = array('operator');
                $o += 8;
                goto st4;
            }
            if (preg_match('(;[^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 5;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st5;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 6;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token, regex, escaped, operator, COMMENT (;[^\\n]*) or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st1:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt5;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st2:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt5;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st3:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 13;
                $os[] = array(' ');
                $o += 1;
                goto st13;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st4:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 14;
                $os[] = array(' ');
                $o += 1;
                goto st14;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st5:
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
        st6:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 15;
                $os[] = array(' ');
                $o += 1;
                goto st15;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st7:
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
        st8:
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
        st9:
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
        st10:
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
        st11:
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
        st12:
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
        st13:
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 18;
                $os[] = array('token');
                $o += 5;
                goto st18;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token at line ' . $el . ', column ' . $ec);
        st14:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 19;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st19;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st15:
        if ($l > $o) {
            if (substr_compare($string, '->', $o, 2) === 0) {
                $sts[] = 20;
                $os[] = array('->');
                $o += 2;
                goto st20;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect -> at line ' . $el . ', column ' . $ec);
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
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceItems($r0, $r1);
                array_pop($sts);
                array_pop($sts);
                goto gt0;
            }
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 1;
                $os[] = array('token');
                $o += 5;
                goto st1;
            }
            if (substr_compare($string, 'regex', $o, 5) === 0) {
                $sts[] = 2;
                $os[] = array('regex');
                $o += 5;
                goto st2;
            }
            if (substr_compare($string, 'escaped', $o, 7) === 0) {
                $sts[] = 3;
                $os[] = array('escaped');
                $o += 7;
                goto st3;
            }
            if (substr_compare($string, 'operator', $o, 8) === 0) {
                $sts[] = 4;
                $os[] = array('operator');
                $o += 8;
                goto st4;
            }
            if (preg_match('(;[^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 5;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st5;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 6;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st6;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token, regex, escaped, operator, COMMENT (;[^\\n]*), NAME ([a-zA-Z_][a-zA-Z_0-9]*), end of string or \\n at line ' . $el . ', column ' . $ec);
        st17:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 22;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st22;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st18:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceEscapedTokenType($r0, $r1, $r2);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                goto gt5;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st19:
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
        st20:
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
        st21:
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
        st22:
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
        st23:
        if ($l > $o) {
            if (preg_match('([0-9]+)ADs', $string, $m, 0, $o)) {
                $sts[] = 26;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st26;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect INTEGER ([0-9]+) at line ' . $el . ', column ' . $ec);
        st24:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 27;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st27;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st25:
        if ($l > $o) {
            if (preg_match('([^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 29;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st29;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ROL ([^\\n]*) at line ' . $el . ', column ' . $ec);
        st26:
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
        throw new \Exception('Expect space, end of string or \\n at line ' . $el . ', column ' . $ec);
        st27:
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
        st28:
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
        st29:
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
        st30:
        if ($l > $o) {
            if (substr_compare($string, 'left', $o, 4) === 0) {
                $sts[] = 32;
                $os[] = array('left');
                $o += 4;
                goto st32;
            }
            if (substr_compare($string, 'right', $o, 5) === 0) {
                $sts[] = 33;
                $os[] = array('right');
                $o += 5;
                goto st33;
            }
            if (substr_compare($string, 'nonassoc', $o, 8) === 0) {
                $sts[] = 34;
                $os[] = array('nonassoc');
                $o += 8;
                goto st34;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect left, right or nonassoc at line ' . $el . ', column ' . $ec);
        st31:
        if ($l > $o) {
            if (substr_compare($string, '{', $o, 1) === 0) {
                $sts[] = 36;
                $os[] = array('{');
                $o += 1;
                goto st36;
            }
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
        throw new \Exception('Expect { or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st32:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt7;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt7;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st33:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt7;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt7;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st34:
        if ($o === $l) {
            $r0 = array_pop($os);
            $os[] = $this->reduceIdentity($r0);
            array_pop($sts);
            goto gt7;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceIdentity($r0);
                array_pop($sts);
                goto gt7;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st35:
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
        st36:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 38;
                $os[] = array(' ');
                $o += 1;
                goto st38;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st37:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceSequenceItems($r0, $r1, $r2);
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
        st38:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 39;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st39;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 40;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st40;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st39:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt9;
            }
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt9;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceReduceActionPointer($r0);
                array_pop($sts);
                goto gt9;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, ) or , at line ' . $el . ', column ' . $ec);
        st40:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceCallReduceAction($r0);
                array_pop($sts);
                goto gt8;
            }
            if (substr_compare($string, '(', $o, 1) === 0) {
                $sts[] = 43;
                $os[] = array('(');
                $o += 1;
                goto st43;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ( or space at line ' . $el . ', column ' . $ec);
        st41:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 44;
                $os[] = array(' ');
                $o += 1;
                goto st44;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st42:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceCopyReduceAction($r0);
                array_pop($sts);
                goto gt8;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st43:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 39;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st39;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st44:
        if ($l > $o) {
            if (substr_compare($string, '}', $o, 1) === 0) {
                $sts[] = 47;
                $os[] = array('}');
                $o += 1;
                goto st47;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect } at line ' . $el . ', column ' . $ec);
        st45:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $sts[] = 48;
                $os[] = array(')');
                $o += 1;
                goto st48;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $sts[] = 49;
                $os[] = array(',');
                $o += 1;
                goto st49;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        st46:
        if ($l > $o) {
            if (substr_compare($string, ')', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt10;
            }
            if (substr_compare($string, ',', $o, 1) === 0) {
                $r0 = array_pop($os);
                $os[] = $this->reduceArrayOf($r0);
                array_pop($sts);
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        st47:
        if ($o === $l) {
            $r10 = array_pop($os);
            $r9 = array_pop($os);
            $r8 = array_pop($os);
            $r7 = array_pop($os);
            $r6 = array_pop($os);
            $r5 = array_pop($os);
            $r4 = array_pop($os);
            $r3 = array_pop($os);
            $r2 = array_pop($os);
            $r1 = array_pop($os);
            $r0 = array_pop($os);
            $os[] = $this->reduceRuleDef($r0, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            array_pop($sts);
            goto gt4;
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $r10 = array_pop($os);
                $r9 = array_pop($os);
                $r8 = array_pop($os);
                $r7 = array_pop($os);
                $r6 = array_pop($os);
                $r5 = array_pop($os);
                $r4 = array_pop($os);
                $r3 = array_pop($os);
                $r2 = array_pop($os);
                $r1 = array_pop($os);
                $r0 = array_pop($os);
                $os[] = $this->reduceRuleDef($r0, $r1, $r2, $r3, $r4, $r5, $r6, $r7, $r8, $r9, $r10);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
                array_pop($sts);
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
        throw new \Exception('Expect end of string or \\n at line ' . $el . ', column ' . $ec);
        st48:
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
                goto gt8;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st49:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 50;
                $os[] = array(' ');
                $o += 1;
                goto st50;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st50:
        if ($l > $o) {
            if (preg_match('(\\$([0-9]+))ADs', $string, $m, 0, $o)) {
                $sts[] = 39;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st39;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect EXPRESSION_POINTER (\\$([0-9]+)) at line ' . $el . ', column ' . $ec);
        st51:
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
                goto gt10;
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
                goto gt10;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ) or , at line ' . $el . ', column ' . $ec);
        gt0:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 7;
                goto st7;
        }
        gt1:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 8;
                goto st8;
            case 16:
                $sts[] = 21;
                goto st21;
        }
        gt2:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 9;
                goto st9;
            case 16:
                $sts[] = 9;
                goto st9;
        }
        gt3:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 10;
                goto st10;
            case 16:
                $sts[] = 10;
                goto st10;
        }
        gt4:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 11;
                goto st11;
            case 16:
                $sts[] = 11;
                goto st11;
        }
        gt5:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 12;
                goto st12;
            case 16:
                $sts[] = 12;
                goto st12;
        }
        gt6:
        switch ($sts[count($sts) - 1]) {
            case 24:
                $sts[] = 28;
                goto st28;
        }
        gt7:
        switch ($sts[count($sts) - 1]) {
            case 30:
                $sts[] = 35;
                goto st35;
        }
        gt8:
        switch ($sts[count($sts) - 1]) {
            case 38:
                $sts[] = 41;
                goto st41;
        }
        gt9:
        switch ($sts[count($sts) - 1]) {
            case 38:
                $sts[] = 42;
                goto st42;
            case 43:
                $sts[] = 46;
                goto st46;
            case 50:
                $sts[] = 51;
                goto st51;
        }
        gt10:
        switch ($sts[count($sts) - 1]) {
            case 43:
                $sts[] = 45;
                goto st45;
        }
    }
    protected abstract function reduceGrammar($p0);
    protected abstract function reduceItems($p0, $p1, $p2 = null);
    protected abstract function reduceArrayOf($p0);
    protected abstract function reduceIdentity($p0);
    protected abstract function reduceComment($p0);
    protected abstract function reduceTokenDef($p0, $p1, $p2, $p3, $p4);
    protected abstract function reduceEscapedTokenType($p0, $p1, $p2);
    protected abstract function reduceOperatorDef($p0, $p1, $p2, $p3, $p4, $p5 = null, $p6 = null);
    protected abstract function reduceRuleDef($p0, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10);
    protected abstract function reduceSequenceItems($p0, $p1, $p2);
    protected abstract function reduceCopyReduceAction($p0);
    protected abstract function reduceCallReduceAction($p0, $p1 = null, $p2 = null, $p3 = null);
    protected abstract function reduceReduceActionArgs($p0, $p1, $p2, $p3);
    protected abstract function reduceReduceActionPointer($p0);
}