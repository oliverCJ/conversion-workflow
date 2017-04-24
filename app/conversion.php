<?php
namespace workflow\app;
/**
 * 自动转换进制
 */
class Conversion {

    protected $icon = 'icon.png';
    protected $result = array();

    public function __construct($query)
    {
        $this->workFlows = new \workflow\Workflows();
        $this->getResult($query);
        $this->display();
    }

    private function getResult($query)
    {
        if (empty($query)) {
            $this->result['need'] = 10;
            return;
        }
        $baseCover = '';
        if (strtolower(substr($query,0,2)) == '0x') {
            $baseCover = 16;
            $query = substr($query, 2);
            if (empty($query)) {
                $this->result['need'] = 16;
                return;
            }
            if (!ctype_xdigit($query)) {
                $this->result['error'] = '错误的16进制数据';
                return ;
            }
        } elseif (strtolower(substr($query,0,2)) == '0c') {
            $baseCover = 8;
            $query = substr($query, 2);
            if (empty($query)) {
                $this->result['need'] = 8;
                return;
            }
            $len = strlen($query);
            for ($i=0; $i < $len; $i++) { 
                if (!ctype_digit($query[$i]) || $query[$i] > 7) {
                    $this->result['error'] = '错误的8进制数据';
                    return;
                }
            }
        } elseif (strtolower(substr($query,0,1)) == 'b') {
            $baseCover = 2;
            $query = substr($query, 1);
            if (empty($query)) {
                $this->result['need'] = 2;
                return;
            }
            $len = strlen($query);
            for ($i=0; $i < $len; $i++) { 
                if (!ctype_digit($query[$i]) || $query[$i] > 1) {
                    $this->result['error'] = '错误的2进制数据';
                    return;
                }
            }
        } else {
            $baseCover = 10;
            $len = strlen($query);
            for ($i=0; $i < $len; $i++) { 
                if (!ctype_digit($query[$i])) {
                    $this->result['error'] = '错误的10进制数据';
                    return;
                }
            }
        }
        $this->toBinary($query, $baseCover);
        $this->toHex($query, $baseCover);
        $this->toDec($query, $baseCover);
        $this->toOct($query, $baseCover);
    }

    private function display()
    {
        if (!empty($this->result)) {
            if (isset($this->result['error'])) {
                $this->workFlows->result(0, '', $this->result['error'], '', $this->icon);
            } elseif (isset($this->result['need'])) {
                $this->workFlows->result(0, '', '请输入' . $this->result['need'] . '进制数据', '', $this->icon);
            } else {
                $current = $this->result['current'];
                foreach ($this->result as $key => $value) {
                    switch ($key) {
                        case 'hex':
                            $value = strtoupper($value);
                            $this->workFlows->result($key, '0x' . $value, '16进制：' . $value, '转换前类型：' . $current . '进制 (回车复制到剪贴板)', $this->icon);
                            break;
                        case 'dec':
                            $this->workFlows->result($key, $value, '10进制：' . $value, '转换前类型：' . $current . '进制 (回车复制到剪贴板)', $this->icon);
                            break;
                        case 'oct':
                            $this->workFlows->result($key, '0c' . $value, '8进制：' . $value, '转换前类型：' . $current . '进制 (回车复制到剪贴板)', $this->icon);
                            break;
                        case 'bin':
                            $this->workFlows->result($key, 'b' . $value, '2进制：' . $value, '转换前类型：' . $current . '进制 (回车复制到剪贴板)', $this->icon);
                            break;
                        default:
                            break;
                    }
                }
            }
        } else {
            $this->workFlows->result(0, '', '请输入字符', '', $this->icon);
        }
        echo $this->workFlows->toxml();
    }

    /**
     * 转为16进制
     * @return [type] [description]
     */
    private function toHex($query, $from)
    {
        if ($from == 16) {
            return $this->result['current'] = $from;
        }
        $re = base_convert($query, $from, 16);
        $this->result['hex'] = $re;
    }

    /**
     * 转为2进制
     * @return [type] [description]
     */
    private function toBinary($query, $from)
    {
        if ($from == 2) {
            return $this->result['current'] = $from;
        }
        $re = base_convert($query, $from, 2);
        $this->result['bin'] = $re;
    }

    /**
     * 转为10进制
     * @return [type] [description]
     */
    private function toDec($query, $from)
    {
        if ($from == 10) {
            return $this->result['current'] = $from;
        }
        $re = base_convert($query, $from, 10);
        $this->result['dec'] = $re;
    }

    /**
     * 转为8进制
     * @return [type] [description]
     */
    private function toOct($query, $from)
    {
        if ($from == 8) {
            return $this->result['current'] = $from;
        }
        $re = base_convert($query, $from, 8);
        $this->result['oct'] = $re;
    }
}
