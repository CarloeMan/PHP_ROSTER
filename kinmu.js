const ON_FLG = "1";
// 前月／翌月ボタン押下時
function monthChange(agoflg) {
    let dispYM = document.getElementsByName("dispYM")[0].value;
    let dispYear  = dispYM.substr(0, 4);  // 表示年
    let dispMonth = dispYM.substr(4);     // 表示月
    let intMonth = Number.parseInt(dispMonth);
    if (agoflg) {
        intMonth = intMonth - 1;
    } else {
        intMonth = intMonth + 1;
    }
    if (intMonth < 1 || intMonth > 12 ) {
        let intYear = Number.parseInt(dispYear);
        if (intMonth < 1) {
            intYear = intYear - 1;
            intMonth = 12;
        } else {
            intYear = intYear + 1;
            intMonth = 1;
        }
        dispYear = intYear.toString();
    } 
    if (intMonth < 10) {
        dispMonth = "0" + intMonth.toString();

    } else {
        dispMonth = intMonth.toString();
    }
    dispYM = dispYear + dispMonth;
    document.getElementsByName("dispYM")[0].value = dispYM;
    document.kinmu.submit();
}
// 画面表示時
function onLoad() {
    let dispYM = document.getElementsByName("dispYM")[0].value;
    let nowYM = document.getElementsByName("nowYM")[0].value;
    if (dispYM != nowYM) {
        document.getElementsByName("btnStart")[0].style.display ="none"; // 業務開始ボタン
        document.getElementsByName("btnEnd")[0].style.display ="none";   // 業務終了ボタン
    }
    if (document.getElementsByName("startFlg")[0].value == "1") {
        document.getElementsByName("startSumiFlg")[0].value = "1";
        document.getElementsByName("startFlg")[0].value = "";
    }
    if (document.getElementsByName("endFlg")[0].value == "1") {
        document.getElementsByName("endSumiFlg")[0].value = "1";
        document.getElementsByName("endFlg")[0].value = "";    
    }
}
// formタグ内のパラメータ値submit
function frmSubmit(startflg) {
    let msg = "勤務";
    if (startflg) {
        msg += "開始"; 
    } else {
        msg += "終了"; 
    }
    msg += "時間を確定します。\n確定後は変更できません。よろしいですか？";
    if (!window.confirm(msg)) {
        return;
    }
    if (startflg) {
        document.getElementsByName("startFlg")[0].value = ON_FLG;
    } else {
        document.getElementsByName("endFlg")[0].value = ON_FLG;
    }
    document.kinmu.submit();
}