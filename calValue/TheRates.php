<?php


require_once 'TheDates.php';


class TheRates
{
    
    private $d3_total_Period = 0;

    
    private $first_z_PI_day=1;
    private $sum_z_PI_day=0;
    
    private $first_z_PI_per=1;
    private $sum_z_PI_per=0;
    

    private $data_z_R_day;                            // 当前期的息率 = 年率 /360* 本期天数
    private $data_z_PI_day;                            // <1+当前期的息率>连乘积
    private $data_z_R_per;                          //按整期的利率
    private $data_z_PI_per;                            // <1+整期的息率>连乘积
//    private $data_z_ByDay;                            // 实际是按天算利息
    
    
    public function __construct($num)
    {
        //        $this->data_start_date = date_create();
        
        $this->data_z_R_day = array();
        $this->data_z_PI_day = array();
        $this->data_z_PI_per = array();
        
        $this->d3_total_Period = $num;
        
        $this->first_z_PI_day=1;
        $this->sum_z_PI_day=0;
        $this->first_z_PI_per=1;
        $this->sum_z_PI_per=0;
        
        
        $this->data_z_R_per = 0;
        
        for ($i=0 ; $i<=$this->d3_total_Period+1;$i++){
            $this->data_z_R_day[$i] = 0;
            $this->data_z_PI_day[$i] = 1;
            $this->data_z_PI_per[$i] = 1;
//            $this->data_z_ByDay[$i] = false;
        }
        
        
    }
    
    
    public function __destruct() {
        echo 'Destroying: ';
        //, $this->name, PHP_EOL;
        for ($i = $this->d3_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->data_z_R_day) && isset($this->data_z_R_day[$i]))
                unset($this->data_z_R_day[$i]);
            if (is_array($this->data_z_PI_day) && isset($this->data_z_PI_day[$i]))
                unset($this->data_z_PI_day[$i]);
            if (is_array($this->data_z_PI_per) && isset($this->data_z_PI_per[$i]))
                unset($this->data_z_PI_per[$i]);
//            if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
//                unset($this->data_z_ByDay[$i]);
        }
        $this->data_z_R_day = null;
        $this->data_z_PI_day = null;
        $this->data_z_PI_per = null;
//        $this->data_z_ByDay = null;
    }
    
    
    private function set_z_R_per( $real_day_rate, $len )
    {

        if ($len > 0) {
            $this->data_z_R_per = $len * $real_day_rate;
        }
        if ($len == 0) {
            $this->data_z_R_per = 15 * $real_day_rate;
        }
        if ($len < 0 && $len > -25 ) {
            $this->data_z_R_per = 30 * (- $len) * $real_day_rate;
        }
        if ($len <= -25 ) {
            $this->data_z_R_per = 0;
        }
    }
    
    private function get_z_R_per(  ) {
        return $this->data_z_R_per;
    }
    
    private function set_z_R_day($num,$z1b)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return;
            if (is_array($this->data_z_R_day) && isset($this->data_z_R_day[$num])) {
                $this->data_z_R_day[$num] = $z1b;
            }
            return;
    }
    
    private function get_z_R_day($num)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 0;
        if (is_array($this->data_z_R_day) && isset($this->data_z_R_day[$num])) {
            return $this->data_z_R_day[$num];
        }
        return 0;
    }
    
    private function set_z_PI_day($num,$mult_pai)  // = false))
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
            
            $r = $this->get_z_R_day($num);
            
            if (is_array($this->data_z_PI_day) && isset($this->data_z_PI_day[$num])) {
                $this->data_z_PI_day[$num] = ( $r  + 1 ) * $mult_pai;
            }
            return $this->data_z_PI_day[$num];  // 不用return 数字的 ????
    }
    
    
    private function get_z_PI_day($num)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
        if (is_array($this->data_z_PI_day) && isset($this->data_z_PI_day[$num])) {
            return $this->data_z_PI_day[$num];
        }
        return 1;
    }
    
    
    private function set_z_PI_per($num,$mult_pai)  // = false))
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
        
        $r = $this->get_z_R_per();
        
        if (is_array($this->data_z_PI_per) && isset($this->data_z_PI_per[$num])) {
            $this->data_z_PI_per[$num] = ( $r  + 1 ) * $mult_pai;
        }
        return $this->data_z_PI_per[$num];  // 不用return 数字的 ????
    }
    
    
    private function get_z_PI_oer($num)
    { // 获取???
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 1;
        if (is_array($this->data_z_PI_per) && isset($this->data_z_PI_per[$num])) {
            return $this->data_z_PI_per[$num];
        }
        return 1;
    }
    
    
    
    
    
    public function getCount()
    { // ???
        return $this->d3_total_Period;
    }
    
    
    private function fix_z_R( $x, $real_day_rate, $days, $len,$useSelfDay = false)
    {
        if ($useSelfDay) {
            $this->set_z_R_day($x, $days * $real_day_rate); // real_rate / 360.0;
            return;
        }
        
        if ($x == 1 || $x == $this->d3_total_Period) {
            $this->set_z_R_day($x, $days * $real_day_rate); // real_rate / 360.0;
            return;
        }
        
        if ($len > 0) {
            $this->set_z_R_day($x, $len * $real_day_rate);
        }
        if ($len == 0) {
            $this->set_z_R_day($x, 15 * $real_day_rate);
        }
        if ($len < 0) {
            $this->set_z_R_day($x, 30 * (- $len) * $real_day_rate);
        }        
    }
    
    private function cal_Rate_PI(){ // 算月还,是按期,还是按天
        
        $num = $this->getCount();
        
        
        $this->sum_z_PI_day = 0; // 从 2 到 第 25 个 z_pai 求和
        for ($x = $num; $x >= 1; $x --) {
            $mult_pai = $this->get_z_PI_day($x + 1);
            $this->set_z_PI_day($x, $mult_pai);
            $this->sum_z_PI_day = $this->sum_z_PI_day + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
        }
        
        $this->first_z_PI_day = $this->get_z_PI_day(1); //  第1 个 z_pai
            
            /*
            $mult_pai = 1;
            for ($x=$num; $x >= 1; $x--)
            {
                $this->sum_z_pai = $this->sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
                $mult_pai = ( $this->get_z_R_per()+1 )*$mult_pai ;
            }
            
            $this->first_z_pai = $mult_pai; //  第1 个 z_pai
            */
        $this->sum_z_PI_per = 0;
        for ($x = $num; $x >= 1; $x --) {
            $mult_pai = $this->get_z_PI_per($x + 1);
            $this->set_z_PI_per($x, $mult_pai);
            $this->sum_z_PI_per = $this->sum_z_PI_per + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
        }
        
        $this->first_z_PI_per = $this->get_z_PI_per(1); //  第1 个 z_pai
            
        
        
    }
    
    public function cal_Average_Amount($total,$useSelfDay) {
        if ( $useSelfDay ) {
            $amt = $total * $this->first_z_PI_day / $this->sum_z_PI_day; // 求精确月供
        } else {
            $amt = $total * $this->first_z_PI_per / $this->sum_z_PI_per; // 求精确月供
        }
        //$amt = round( $amt, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        return $amt;
    }
    
    public function cal_Period_Interest($num, $total_amt, $useSelfDay = false){ // 算月还,是按期,还是按天
        if ($num < 1 || $num > $this->d3_total_Period )
            return 0;
        
        if ( $useSelfDay ) { // 按天
            $intD = $total_amt * $this->get_z_R_day($num);
        } else {
            $intD = $total_amt * $this->get_z_R_per(  );
        }
        
        //$amt = round( $amt, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        $intL = intval( round( $intD, 0, PHP_ROUND_HALF_UP ) ); // 求四舍五入到分月供
        return $intL;
    }
    
        
    
    
    public function cal_theRates($theDates,$rate,$useDay) {
        
        if ( (! ($theDates instanceof TheDates)) || (! isset($theDates)) ) {
            return;
        }
        
        $len = $theDates->getPeriod_Len();
        $num = $theDates->getCount();
        if ( $num <=0 ) return;
        if ( $this->getCount() != $num  ) {
            $this->__destruct();
            $this->__construct($num);
        }
        
        
        $real_day_rate = $rate / 360.0;
        
        for ($x=1; $x <= $num; $x++)
        {
            $days = $theDates->getDueDays( $x );
            
//            $this->fix_z_R( $x, $real_day_rate,$days, $len,$useDay ); // $this->d2_real_day_rate, false 按期，true 按天
            $this->set_z_R_day($x, $days * $real_day_rate); // real_rate / 360.0;
        }
        
        $this->set_z_R_per( $real_day_rate, $len );
        $this->cal_Rate_PI();
        
        
        
        
        
        //       $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
        //$this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        
    }
    
    public function echoData( $need_table=true )
    {
        if ( $need_table ) {
            //echo date_default_timezone_get();
            
            $echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) {
                $echoStr = $echoStr."    <tr>\n";
                
                
                $echoStr = $echoStr."        <td>".$x."</td>\n";
                //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
                $echoStr = $echoStr."        <td>".$this->data_z_PI_day[$x]."</td>\n";
                $echoStr = $echoStr."        <td>".$this->data_z_R_day[$x]."</td>\n";
               
                $echoStr = $echoStr."\n";
                
                
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
            $echoStr = $echoStr."_".$this->first_z_PI_day."_".$this->sum_z_PI_day."<br>\n";
            
            
            echo $echoStr;
            
        }
        
    }
           
    
}