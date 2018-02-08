<?php


require_once 'calValue/TheRates.php';
require_once 'calValue/TheDates.php';



class ThePayments
{
    // 1-1098按设置固定天（ 多期、一期），
    // 0按半月，-1按月，-2双月，-3三月，-4四月，-5五月，-6六月、-7七月、-8八月、-9九月、-10十月、-11十月、-12一年、（ 多期、一期）
    // -13 .. -24两年，（ 多期、一期）
    // -25按指定天,（ 多期、一期）
    
    private $d1_all_loan = 0;
    private $d3_total_Period = 0;
    
    
    private $d6_Fixed_Payment = 0.0;
    private $d6_Fixed_Payment_Round = 0;
    
    private $d_Principal = array();
    private $d_DuePrincipal = array();
    private $d_DueInterest = array();
    
    
    const mode_PHP_ROUND_HALF_UP = PHP_ROUND_HALF_UP;
    const mode_PHP_ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN; 
    const mode_PHP_ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN; 
    const mode_PHP_ROUND_HALF_ODD = PHP_ROUND_HALF_ODD; 
    
    private $d_pmt_roundingMode = PHP_ROUND_HALF_UP;
    private $d_I_roundingMode = PHP_ROUND_HALF_UP;
    
    /*
    define ('PHP_ROUND_HALF_UP', 1);
    define ('PHP_ROUND_HALF_DOWN', 2);
    define ('PHP_ROUND_HALF_EVEN', 3);
    define ('PHP_ROUND_HALF_ODD', 4);
    */
    

    
    public function __construct($num)
    {
        //        $this->data_start_date = date_create();
        $this->initMe($num);
    }
    
    
    public function __destruct()
    {
        $this->releaseMe();
        
    }
    
    private function initMe($num)
    {
        //        $this->data_start_date = date_create();
        if ($num <= 0) {
            $this->d3_total_Period = 0;
            return;
        }
        
        $this->d3_total_Period = $num;
        
        $this->d_Principal = array();
        $this->d_DuePrincipal = array();
        $this->d_DueInterest = array();
        
        
        
        
        for ($i=0 ; $i<=$num+1;$i++){
            $this->d_Principal[$i] = 0;
            $this->d_DuePrincipal[$i] = 0;
            $this->d_DueInterest[$i] = 0;
            //            $this->data_z_ByDay[$i] = false;
        }
    }

    private function releaseMe()
    {
        echo 'Destroying: ';
        // , $this->name, PHP_EOL;
        for ($i = $this->d3_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->d_Principal) && isset($this->d_Principal[$i]))
                unset($this->d_Principal[$i]);
            if (is_array($this->d_DuePrincipal) && isset($this->d_DuePrincipal[$i]))
                unset($this->d_DuePrincipal[$i]);
            if (is_array($this->d_DueInterest) && isset($this->d_DueInterest[$i]))
                unset($this->d_DueInterest[$i]);
            // if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
            // unset($this->data_z_ByDay[$i]);
        }
        $this->d_Principal = null;
        $this->d_DuePrincipal = null;
        $this->d_DueInterest = null;
        // $this->data_z_ByDay = null;
    }
    
    public function getCount()
    { // ???
        return $this->d3_total_Period;
    }
    
    public function setCount($num)
    { // ???
        if ( $num != $this->d3_total_Period ) {
            $this->releaseMe();
            $this->initMe($num);
        }
    }
    
    
    public function setRoundingMode( $f_pmt_mode, $interest_mode ) {
        $this->d_pmt_roundingMode = $f_pmt_mode;
        $this->d_I_roundingMode = $interest_mode;
    }
    public function set_Fixed_Payment( $f_pmt) {
        $this->d6_Fixed_Payment = $f_pmt;
        $this->d6_Fixed_Payment_Round =  intval( round( $f_pmt, 0, $this->d_pmt_roundingMode ) );
        return $this->d6_Fixed_Payment_Round;
    }
    
    public function get_Fixed_Payment() {
        return $this->d6_Fixed_Payment_Round;
    }
    
    public function setAllPrincipal( $Principal) {
        $this->d1_all_loan = intval( round( $Principal, 0, ThePayments::mode_PHP_ROUND_HALF_UP ) );
        //				( long ) com.wj.fin.wjutil.TheTools.round_half_up( all_loan*100, 0 );
    }
    
    public function setPrincipal($num, $Principal) {
        if ( $num <0 || $num > $this->getCount() ) return;
        $this->d_Principal[$num] = $Principal;
    }
    
    public function setDuePrincipal( $num, $duePrincipal) {
        if ( $num <0 || $num > $this->getCount() ) return;
        $this->d_DuePrincipal[$num] = $duePrincipal;
    }
    
    public function setDueInterest( $num, $DueInterest) {
        if ( $num <0 || $num > $this->getCount() ) return;
        $this->d_DueInterest[$num] = intval( round( $DueInterest, 0, $this->d_I_roundingMode ) );

    }
    
    public function getAllPrincipal() {
        return $this->d1_all_loan;
    }
    
    public function getPrincipal($num) {
        if ( $num <0 || $num > $this->getCount() ) return 0;
        return $this->d_Principal[$num];
    }
    
    public function getDuePrincipal( $num) {
        if ( $num <0 || $num > $this->getCount() ) return 0;
        return $this->d_DuePrincipal[$num];
    }
    
    public function getDueInterest( $num) {
        if ( $num <0 || $num > $this->getCount() ) return 0;
        return $this->d_DueInterest[$num];
    }
    
    public function getPrincipals() {
        $num = $this->getCount();
        if ( $num <= 0 ) return null;
        
        $a_array = array();
        for ($i=0;$i<$num;$i++) {
            $a_array[$i] = $this->d_Principal[$i+1];
        }
        return $a_array;
    }
    
    public function getDuePrincipals() {
        $num = $this->getCount();
        if ( $num <= 0 ) return null;
        
        $a_array = array();
        for ($i=0;$i<$num;$i++) {
            $a_array[$i] = $this->d_DuePrincipal[$i+1];
        }
        return $a_array;
    }
    
    public function getDueInterests() {
        $num = $this->getCount();
        if ( $num <= 0 ) return null;
        
        $a_array = array();
        for ($i=0;$i<$num;$i++) {
            $a_array[$i] = $this->d_DueInterest[$i+1];
        }
        return $a_array;
    }
    
    
    
    
    
    
    public function cal_thePayments( $theRates, $all_loan, $useDay)
    {
        
        if ( (! ($theRates instanceof TheRates)) || (! isset($theRates)) ) {
            return;
        }
        
        $num = $theRates->getCount();
        if ( $num <=0 ) return;
        if ( $this->getCount() != $num  ) {
            $this->__destruct();
            $this->__construct($num);
        }
        
        
        if ( $all_loan < 0 ) { $all_loan = 0; }
        
        $this->d1_all_loan =  intval( round( $all_loan * 100, 0, PHP_ROUND_HALF_UP ) );

        $this->d3_total_Period = $num; // 总期数不能小于1
        
        

        $this->d_Principal[0] = $this->d1_all_loan;
        $this->d_DuePrincipal[0] = 0;
        
        
        $this->d6_Fixed_Payment = $theRates->cal_Period_Amount($this->d1_all_loan);
        $this->d6_Fixed_Payment_Round = intval( round( $this->d6_Fixed_Payment, 0, PHP_ROUND_HALF_UP ) ); // 求四舍五入到分月供

        
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $num; $x++) {
            $amt = $this->d_Principal[$x-1]-$this->d_DuePrincipal[$x-1];
            $this->d_Principal[$x] =  $amt;
            $this->d_DueInterest[$x] = $theRates->cal_Period_Interest($x, $amt,$useDay );
            $this->d_DuePrincipal[$x] = $this->d6_Fixed_Payment_Round - $this->d_DueInterest[$x];
        }
        
        $this->cal_last_period_due_principal();
        
        $amt = $this->d_Principal[1];
        $this->d_DueInterest[1] = $theRates->cal_Period_Interest(1, $amt,true );
        
        $x = $this->d3_total_Period;
        $amt = $this->d_Principal[$x];
        $this->d_DueInterest[$x] = $theRates->cal_Period_Interest($x, $amt,true );
        
    }
    
    
    private function cal_last_period_due_principal()
    { // 修正最后一期应还本金，如果没还完本金，全部归还。
        $num = $this->getCount();
        if ( $this->d_DuePrincipal[$num] != $this->d_Principal[$num] )
        {
            $this->d_DuePrincipal[$num] = $this->d_Principal[$num];
        }
    //    $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
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
                $echoStr = $echoStr."        <td>".($this->d_Principal[$x]/100)."</td>\n";
                $echoStr = $echoStr."        <td>".($this->d_DuePrincipal[$x]/100)."</td>\n";
                $echoStr = $echoStr."        <td>".($this->d_DueInterest[$x]/100)."</td>\n";
                $echoStr = $echoStr."        <td>".(($this->d_DuePrincipal[$x]+$this->d_DueInterest[$x])/100)."</td>\n";
                
                $echoStr = $echoStr."\n";
                
                
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
            
            
            echo $echoStr;
            
        }
        
    }
    
    
    
    
    
}

?>