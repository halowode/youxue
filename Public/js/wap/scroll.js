var eventFn=[];
var scrollLoadingNews = function() {
	var eventType = "scroll",
	win = $(window),
	d = document,
	html = d.documentElement,
	body = d.body,
	threshold = 500;
	var newsMain = $("body"),
	newsLoading = newsMain.find(".news-loading"),
	newsLoadingMore = newsMain.find(".news-loading-more"),
	newsLoadingStatus = newsMain.find(".news-loading-status");
	var clientHeight = html.clientHeight,
	scrollHeight = body.offsetHeight;
	var resizeTimeout, scrollTimeout;
	var _updateHeight = function() {
		clientHeight = html.clientHeight;
		scrollHeight = body.offsetHeight;
	};
	win.on("resize",
	function() {
		clearTimeout(resizeTimeout);
		resizeTimeout = setTimeout(function() {
			_updateHeight();
		},
		300);
	});
	var loadingStatus = 0;
	var _fn = function(jqDom,type, sectionId) {
		_updateHeight();
		return function() {
			clearTimeout(scrollTimeout);
			scrollTimeout = setTimeout(function() {
				var scrollTop = body.scrollTop || html.scrollTop;
				if (scrollTop + clientHeight + threshold > scrollHeight) {
					newsLoadingMore.show();
					var pageIndex = parseInt($("#inputPageIndex").val());
					if (!loadingStatus) {
//						sectionLoadXhr = requestSectionNews({
//							type: type,
//
//							id: sectionId,
//							index: pageIndex,
//							before: function() {
//								loadingStatus = 1;
//							},
//							success: function(data) {
//								if (data && data.code == "00000") {
//									var postListData = data.postList;
//									if (postListData.length > 0) {
//										createNewlist(jqDom, data);
//										_updateHeight();
//									} else {
//										off();
//										newsLoadingMore.hide();
//										newsLoadingStatus.show();
//									}
//								} else {
//									alert( data.desc);
//								}
//								loadingStatus = 0;
//							}
//						});
					}
				}
			},
			50);
		};
	};
	var off = function() {
		eventFn.forEach(function(item) {
			win.off(eventType, item);
		});
	};
	var on = function(jqDom,type, sectionId) {
		var fn = _fn(jqDom,type, sectionId);
		win.on(eventType, fn);
		eventFn.push(fn);
	};
	return {
		off: off,
		on: on
	};
};