<?php
function toast_alert($type, $msg, $title = false)
{
    if ($title === false) {
        $alert_title = "Ops!!";
    } else {
        $alert_title = $title;
    }
    $toast = '<script type="text/javascript">
        $(document).ready(function(){
        
          swal({
            type: "' . $type . '",
            title: "' . $alert_title . '",
            text: "' . $msg . '",
            padding: "2em"
          })
        });
    </script>';
    echo $toast;
}








function TranStatus($result){
    if ($result['trans_status'] === 'processing') {
        return '<span class="text-primary">Transaction Processing</span>';
    }
    if($result['trans_status'] === 'pending'){
        return  '<span class="text-secondary">Transaction Pending</span>';
    }

    if($result['trans_status'] === 'failed') {
        return '<span class="text-danger">Transaction Failed</span>';
    }

    if($result['trans_status'] === 'completed') {
        return '<span class="text-success">Transaction Completed</span>';
    }
    if($result['trans_status'] === 'paid') {
        return '<span class="text-success">Interest Paid</span>';
    }
}


