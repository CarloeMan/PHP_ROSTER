function workStart() {
    document.getElementsByName("startFlg")[0].value = "1";
    confirmDialog();
    frmSubmit();
}

function workEnd() {
    document.getElementsByName("endFlg")[0].value = "1";    
    confirmDialog();
    frmSubmit();
}

function onLoad() {
    if (document.getElementsByName("startFlg")[0].value == "1") {
        document.getElementsByName("startSumiFlg")[0].value = "1";
        document.getElementsByName("startFlg")[0].value = "";
    }
    if (document.getElementsByName("endFlg")[0].value == "1") {
        document.getElementsByName("endSumiFlg")[0].value = "1";
        document.getElementsByName("endFlg")[0].value = "";    
    }
}

// submit
function frmSubmit() {
    document.kinmu.submit();
}

// 
function confirmDialog() {
    let flg = window.confirm("勤務時間を確定します。\n確定後は変更できません。よろしいですか？");
    if(!flg) {
        return;
    }
}