﻿$(function(){
/*
//オブジェクトの中身確認
function printProperties(obj) {
	var properties = '';
	for (var prop in obj){
		properties += prop + "=" + obj[prop] + "\n";
	}
alert(properties);
}
printProperties(WPMRAJS);
*/
	var setArea = $('#item-list'),
	loadNum = 5, // 読み込む個数
	loadTxt = 'Now Loading...', // Loading中の表示テキスト
	btnTxt = 'MORE', // ボタンテキスト
	fadeSpeed = 2000; // フェードスピード

	setArea.after('<button id="more-btn">' + btnTxt + '</button>'); //もっと見るのDOMを追加
	var setMore = setArea.next('#more-btn'); //「もっと見る」のDOM要素を取得

	setMore.click(function(){
		$.ajax({
			//scriptCharset: 'utf-8',
			//url: 'ajax/ajax.php',
			url: MOREIMGS.endpoint,
			type: 'POST',
			data: {action : 'more_images'},
			dataType: 'json',
		}).done(function(data){
				var dataLengh = data.length, //jsonファイル（配列）のアイテム総数(28個)を取得
				loadItemLength = setArea.find('.loadItem').length, //html側のロードエリアにロードしたアイテム（=.loadItem）の個数を取得
				setAdj = (dataLengh)-(loadItemLength), //総数-現在html側で読み込まれている個数 = 読み込まれていないアイテム数
				setBeg = (dataLengh)-(setAdj); //総数-まだ読み込まれていないアイテム数 = すでに読み込まれているアイテム数
				if(!(dataLengh == loadItemLength)){ //総数がすでに読み込まれているアイテムの数と一致しない場合にtrue（jsonのデータを全部読み込まれていないとき）
					setArea.append('<div id="nowLoading">' + loadTxt + '</div>'); //jason表示エリアの最後にロード中のDOMを追加
					if(loadItemLength == 0){ //ロードエリアに読まれているアイテムが0の時=初回の読み込みの時
						if(dataLengh <= loadNum){ //jsonのデータ総数が読み込み指定数以下の時（1回ですべて読み込んでしまうとき）
							for (var i=0; i<dataLengh; i++) { //jsonのデータ数分、<div id="item(i)" class="loadItem">jsonの内容(i)</div>として「setArea」に追加
								$( data[i].itemSource ).appendTo(setArea).css({opacity:'0'}).animate({opacity:'1'},fadeSpeed);
							}
							setMore.remove(); //全部表示済みなので「setMore」のDOMは削除
						} else { //jsonのデータ総数が読み込み指定数より上の時（すべての読み込みに一回以上かかるとき）
							for (var i=0; i<loadNum; i++) { //指定回数分繰り返し
								$( data[i].itemSource ).appendTo(setArea).css({opacity:'0'}).animate({opacity:'1'},fadeSpeed);
							}
						}
					} else if(loadItemLength > 0 && loadItemLength < dataLengh){ //ロードエリアに読まれているアイテムが0より多く、jsonのデータ総数よりすくない場合=2回目以降の読み込みの時
						if(loadNum < setAdj){ //読み込み数量が読み込まれていないアイテム数より少ないとき(今回の読み込みですべて読み込まない場合)
							for (var i=0; i<loadNum; i++) {
								v = i+setBeg; //すでに読み込まれているアイテム数の次のアイテムから読み込み始める(jsonのインデックスは配列だから0から始まるため)
								$( data[v].itemSource ).appendTo(setArea).css({opacity:'0'}).animate({opacity:'1'},fadeSpeed);
							}
						} else if(loadNum >= setAdj){ //読み込み数量が読み込まれていないアイテム数以上の時(今回の読み込みですべて読み込み)
							for (var i=0; i<setAdj; i++) {
								v = i+setBeg;
								$( data[v].itemSource ).appendTo(setArea).css({opacity:'0'}).animate({opacity:'1'},fadeSpeed);
							}
							setMore.remove();
						}
					} else if(loadItemLength == dataLengh){ //html側のアイテム数とデータの総数が一致したとき=すべて読み込み済みの時
						return false;
					}
				} else {  //総数がすでに読み込まれているアイテムの数と一致する場合 = 最後まで読み込み終えている場合
					return false;
				}
			}).fail( function(XMLHttpRequest, textStatus, errorThrown) {
//APIとの通信に失敗した時に実行される。
alert("XMLHttpRequest : " + XMLHttpRequest.status + "\n" + "textStatus : " + textStatus + "\n" + "errorThrown : " + errorThrown.message);
//この様な記述をする事で、APIとの通信に失敗した時にエラーレポートを表示してくれる。
}).always(function() {
				$('#nowLoading').each(function(){
					$(this).remove(); //処理を中断してこのDOM用を削除
				});
				return false; //処理を中断
			}); //always
		return false; //処理を中断
	});
});
