<?php

namespace Chompy\Generator\Definition\PicoGram;

abstract class AbstractPicoGramParser
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
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 5;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st5;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token, regex, escaped, operator or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
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
                $sts[] = 12;
                $os[] = array(' ');
                $o += 1;
                goto st12;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st4:
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
        st5:
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
        st6:
        if ($o === $l) {
            $r0 = array_pop($os);
            return $this->reduceGrammar($r0);
        }
        if ($l > $o) {
            if (substr_compare($string, '
', $o, 1) === 0) {
                $sts[] = 15;
                $os[] = array('
');
                $o += 1;
                goto st15;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect \\n or end of string at line ' . $el . ', column ' . $ec);
        st7:
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
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 16;
                $os[] = array(' ');
                $o += 1;
                goto st16;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st12:
        if ($l > $o) {
            if (substr_compare($string, 'token', $o, 5) === 0) {
                $sts[] = 17;
                $os[] = array('token');
                $o += 5;
                goto st17;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token at line ' . $el . ', column ' . $ec);
        st13:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 18;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st18;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st14:
        if ($l > $o) {
            if (substr_compare($string, '->', $o, 2) === 0) {
                $sts[] = 19;
                $os[] = array('->');
                $o += 2;
                goto st19;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect -> at line ' . $el . ', column ' . $ec);
        st15:
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
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 5;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st5;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect token, regex, escaped, operator, NAME ([a-zA-Z_][a-zA-Z_0-9]*), end of string or \\n at line ' . $el . ', column ' . $ec);
        st16:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 21;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st21;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st17:
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
        st18:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 22;
                $os[] = array(' ');
                $o += 1;
                goto st22;
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
        st21:
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
        st22:
        if ($l > $o) {
            if (preg_match('([0-9]+)ADs', $string, $m, 0, $o)) {
                $sts[] = 25;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st25;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect INTEGER ([0-9]+) at line ' . $el . ', column ' . $ec);
        st23:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 26;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st26;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st24:
        if ($l > $o) {
            if (preg_match('([^\\n]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 28;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st28;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect ROL ([^\\n]*) at line ' . $el . ', column ' . $ec);
        st25:
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
                $sts[] = 29;
                $os[] = array(' ');
                $o += 1;
                goto st29;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space, end of string or \\n at line ' . $el . ', column ' . $ec);
        st26:
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
        st27:
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
        st28:
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
        st29:
        if ($l > $o) {
            if (substr_compare($string, 'left', $o, 4) === 0) {
                $sts[] = 31;
                $os[] = array('left');
                $o += 4;
                goto st31;
            }
            if (substr_compare($string, 'right', $o, 5) === 0) {
                $sts[] = 32;
                $os[] = array('right');
                $o += 5;
                goto st32;
            }
            if (substr_compare($string, 'nonassoc', $o, 8) === 0) {
                $sts[] = 33;
                $os[] = array('nonassoc');
                $o += 8;
                goto st33;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect left, right or nonassoc at line ' . $el . ', column ' . $ec);
        st30:
        if ($l > $o) {
            if (substr_compare($string, '{', $o, 1) === 0) {
                $sts[] = 35;
                $os[] = array('{');
                $o += 1;
                goto st35;
            }
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 36;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st36;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect { or NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st31:
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
        st35:
        if ($l > $o) {
            if (substr_compare($string, ' ', $o, 1) === 0) {
                $sts[] = 37;
                $os[] = array(' ');
                $o += 1;
                goto st37;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect space at line ' . $el . ', column ' . $ec);
        st36:
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
        st37:
        if ($l > $o) {
            if (preg_match('([a-zA-Z_][a-zA-Z_0-9]*)ADs', $string, $m, 0, $o)) {
                $sts[] = 38;
                $os[] = $m;
                $o += strlen($m[0]);
                goto st38;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect NAME ([a-zA-Z_][a-zA-Z_0-9]*) at line ' . $el . ', column ' . $ec);
        st38:
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
        st39:
        if ($l > $o) {
            if (substr_compare($string, '}', $o, 1) === 0) {
                $sts[] = 40;
                $os[] = array('}');
                $o += 1;
                goto st40;
            }
        }
        $els = explode("\n", substr($string, 0, $o));
        $el = count($els);
        $ec = strlen(array_pop($els)) + 1;
        throw new \Exception('Expect } at line ' . $el . ', column ' . $ec);
        st40:
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
        gt0:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 6;
                goto st6;
        }
        gt1:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 7;
                goto st7;
            case 15:
                $sts[] = 20;
                goto st20;
        }
        gt2:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 8;
                goto st8;
            case 15:
                $sts[] = 8;
                goto st8;
        }
        gt3:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 9;
                goto st9;
            case 15:
                $sts[] = 9;
                goto st9;
        }
        gt4:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 10;
                goto st10;
            case 15:
                $sts[] = 10;
                goto st10;
        }
        gt5:
        switch ($sts[count($sts) - 1]) {
            case 0:
                $sts[] = 11;
                goto st11;
            case 15:
                $sts[] = 11;
                goto st11;
        }
        gt6:
        switch ($sts[count($sts) - 1]) {
            case 23:
                $sts[] = 27;
                goto st27;
        }
        gt7:
        switch ($sts[count($sts) - 1]) {
            case 29:
                $sts[] = 34;
                goto st34;
        }
    }
    protected abstract function reduceGrammar($p1);
    protected abstract function reduceItems($p1, $p2, $p3 = null);
    protected abstract function reduceArrayOf($p1);
    protected abstract function reduceIdentity($p1);
    protected abstract function reduceTokenDef($p1, $p2, $p3, $p4, $p5);
    protected abstract function reduceEscapedTokenType($p1, $p2, $p3);
    protected abstract function reduceOperatorDef($p1, $p2, $p3, $p4, $p5, $p6 = null, $p7 = null);
    protected abstract function reduceRuleDef($p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11);
    protected abstract function reduceSequenceItems($p1, $p2, $p3);
}