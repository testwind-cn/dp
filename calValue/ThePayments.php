<?php


require_once 'calValue/TheRates.php';
require_once 'calValue/TheDates.php';



class ThePayments
{
    // 1-1098按设置固定天（ 多期、一期），
    // 0按半月，-1按月，-2双月，-3三月，-4四月，-5五月，-6六月、-7七月、-8八月、-9九月、-10十月、-11十月、-12一年、（ 多期、一期）
    // -13 .. -24两年，（ 多期、一期）
    // -25按指定天,（ 多期、一期）
    
    private $ww_all_loan = 0;
    private $ww_total_Period = 0;
    
    
    private $ww_Fixed_Payment = 0.0;
    private $ww_Fixed_Payment_Round = 0;
    
    private $ww_Principal = array();
    private $ww_DuePrincipal = array();
    private $ww_DueInterest = array();
    
    
    const mode_PHP_ROUND_HALF_UP = PHP_ROUND_HALF_UP;
    const mode_PHP_ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN; 
    const mode_PHP_ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN; 
    const mode_PHP_ROUND_HALF_ODD = PHP_ROUND_HALF_ODD; 
    
    private $ww_pmt_roundingMode = PHP_ROUND_HALF_UP;
    private $ww_I_roundingMode = PHP_ROUND_HALF_UP;
    
    /*
    define ('PHP_ROUND_HALF_UP', 1);
    define ('PHP_ROUND_HALF_DOWN', 2);
    define ('PHP_ROUND_HALF_EVEN', 3);
    define ('PHP_ROUND_HALF_ODD', 4);
    */
    

    
    public function __construct($pp_num)
    {
        //        $this->data_start_date = date_create();
        $this->initMe($pp_num);
    }
    
    
    public function __destruct()
    {
        $this->releaseMe();
        
    }
    
    private function initMe($pp_num)
    {
        //        $this->data_start_date = date_create();
        if ($pp_num <= 0) {
            $this->ww_total_Period = 0;
            return;
        }
        
        $this->ww_total_Period = $pp_num;
        
        $this->ww_Principal = array();
        $this->ww_DuePrincipal = array();
        $this->ww_DueInterest = array();
        
        
        
        
        for ($i=0 ; $i<=$pp_num+1;$i++){
            $this->ww_Principal[$i] = 0;
            $this->ww_DuePrincipal[$i] = 0;
            $this->ww_DueInterest[$i] = 0;
            //            $this->data_z_ByDay[$i] = false;
        }
    }

    private function releaseMe()
    {
        // echo 'Destroying: ';
        // , $this->name, PHP_EOL;
        for ($i = $this->ww_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->ww_Principal) && isset($this->ww_Principal[$i]))
                unset($this->ww_Principal[$i]);
            if (is_array($this->ww_DuePrincipal) && isset($this->ww_DuePrincipal[$i]))
                unset($this->ww_DuePrincipal[$i]);
            if (is_array($this->ww_DueInterest) && isset($this->ww_DueInterest[$i]))
                unset($this->ww_DueInterest[$i]);
            // if (is_array($this->data_z_ByDay) && isset($this->data_z_ByDay[$i]))
            // unset($this->data_z_ByDay[$i]);
        }
        $this->ww_Principal = null;
        $this->ww_DuePrincipal = null;
        $this->ww_DueInterest = null;
        // $this->data_z_ByDay = null;
    }
    
    public function getCount()
    { // ???
        return $this->ww_total_Period;
    }
    
    public function setCount($pp_num)
    { // ???
        if ( $pp_num != $this->ww_total_Period ) {
            $this->releaseMe();
            $this->initMe($pp_num);
        }
    }
    
    
    public function setRoundingMode( $pp_f_pmt_mode, $pp_interest_mode ) {
        $this->ww_pmt_roundingMode = $pp_f_pmt_mode;
        $this->ww_I_roundingMode = $pp_interest_mode;
    }
    public function set_Fixed_Payment( $pp_f_pmt) {
        $this->ww_Fixed_Payment = $pp_f_pmt;
        $this->ww_Fixed_Payment_Round =  intval( round( $pp_f_pmt, 0, $this->ww_pmt_roundingMode ) );
        return $this->ww_Fixed_Payment_Round;
    }
    
    public function get_Fixed_Payment() {
        return $this->ww_Fixed_Payment_Round;
    }
    
    public function setAllPrincipal( $pp_Principal) {
        $this->ww_all_loan = intval( round( $pp_Principal, 0, ThePayments::mode_PHP_ROUND_HALF_UP ) );
        //				( long ) com.wj.fin.wjutil.TheTools.round_half_up( all_loan*100, 0 );
    }
    
    public function setPrincipal($pp_num, $pp_Principal) {
        if ( $pp_num <0 || $pp_num > $this->getCount() ) return;
        $this->ww_Principal[$pp_num] = $pp_Principal;
    }
    
    public function setDuePrincipal( $pp_num, $pp_duePrincipal) {
        if ( $pp_num <0 || $pp_num > $this->getCount() ) return;
        $this->ww_DuePrincipal[$pp_num] = $pp_duePrincipal;
    }
    
    public function setDueInterest( $pp_num, $pp_DueInterest) {
        if ( $pp_num <0 || $pp_num > $this->getCount() ) return;
        $this->ww_DueInterest[$pp_num] = intval( round( $pp_DueInterest, 0, $this->ww_I_roundingMode ) );

    }
    
    public function getAllPrincipal() {
        return $this->ww_all_loan;
    }
    
    public function getPrincipal($pp_num) {
        if ( $pp_num <0 || $pp_num > $this->getCount() ) return 0;
        return $this->ww_Principal[$pp_num];
    }
    
    public function getDuePrincipal( $pp_num) {
        if ( $pp_num <0 || $pp_num > $this->getCount() ) return 0;
        return $this->ww_DuePrincipal[$pp_num];
    }
    
    public function getDueInterest( $pp_num) {
        if ( $pp_num <0 || $pp_num > $this->getCount() ) return 0;
        return $this->ww_DueInterest[$pp_num];
    }
    
    public function getPrincipals() {
        $ll_num = $this->getCount();
        if ( $ll_num <= 0 ) return null;
        
        $a_array = array();
        for ($i=0;$i<$ll_num;$i++) {
            $a_array[$i] = $this->ww_Principal[$i+1];
        }
        return $a_array;
    }
    
    public function getDuePrincipals() {
        $ll_num = $this->getCount();
        if ( $ll_num <= 0 ) return null;
        
        $a_array = array();
        for ($i=0;$i<$ll_num;$i++) {
            $a_array[$i] = $this->ww_DuePrincipal[$i+1];
        }
        return $a_array;
    }
    
    public function getDueInterests() {
        $ll_num = $this->getCount();
        if ( $ll_num <= 0 ) return null;
        
        $a_array = array();
        for ($i=0;$i<$ll_num;$i++) {
            $a_array[$i] = $this->ww_DueInterest[$i+1];
        }
        return $a_array;
    }
    
    
    
    /*
    
    
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
        
        $this->ww_all_loan =  intval( round( $all_loan * 100, 0, PHP_ROUND_HALF_UP ) );

        $this->ww_total_Period = $num; // 总期数不能小于1
        
        

        $this->ww_Principal[0] = $this->ww_all_loan;
        $this->ww_DuePrincipal[0] = 0;
        
        
        $this->ww_Fixed_Payment = $theRates->cal_Period_Amount($this->ww_all_loan);
        $this->ww_Fixed_Payment_Round = intval( round( $this->ww_Fixed_Payment, 0, PHP_ROUND_HALF_UP ) ); // 求四舍五入到分月供

        
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $num; $x++) {
            $amt = $this->ww_Principal[$x-1]-$this->ww_DuePrincipal[$x-1];
            $this->ww_Principal[$x] =  $amt;
            $this->ww_DueInterest[$x] = $theRates->cal_Period_Interest($x, $amt,$useDay );
            $this->ww_DuePrincipal[$x] = $this->ww_Fixed_Payment_Round - $this->ww_DueInterest[$x];
        }
        
        $this->cal_last_period_due_principal();
        
        $amt = $this->ww_Principal[1];
        $this->ww_DueInterest[1] = $theRates->cal_Period_Interest(1, $amt,true );
        
        $x = $this->ww_total_Period;
        $amt = $this->ww_Principal[$x];
        $this->ww_DueInterest[$x] = $theRates->cal_Period_Interest($x, $amt,true );
        
    }
    
    
    private function cal_last_period_due_principal()
    { // 修正最后一期应还本金，如果没还完本金，全部归还。
        $num = $this->getCount();
        if ( $this->ww_DuePrincipal[$num] != $this->ww_Principal[$num] )
        {
            $this->ww_DuePrincipal[$num] = $this->ww_Principal[$num];
        }
    //    $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
    }
    
    */
    
    
    public function echoData( $pp_need_table=true )
    {
        if ( $pp_need_table ) {
            //echo date_default_timezone_get();
            
            $ll_echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->ww_total_Period+1; $x++) {
                $ll_echoStr = $ll_echoStr."    <tr>\n";
                
                
                $ll_echoStr = $ll_echoStr."        <td>".$x."</td>\n";
                //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".($this->ww_Principal[$x]/100)."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".($this->ww_DuePrincipal[$x]/100)."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".($this->ww_DueInterest[$x]/100)."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".(($this->ww_DuePrincipal[$x]+$this->ww_DueInterest[$x])/100)."</td>\n";
                
                $ll_echoStr = $ll_echoStr."\n";
                
                
                $ll_echoStr = $ll_echoStr."    </tr>\n";
            }
            $ll_echoStr = $ll_echoStr."</table>\n";
            
            
            echo $ll_echoStr;
            
        }
        
    }
    
    
    
    
    
}

?>