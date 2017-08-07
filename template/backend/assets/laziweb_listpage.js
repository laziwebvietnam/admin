var data_return = {
    data_id_checked:[]
};

/** Sự kiện onchange của input checkbox trên table trang danh sách */
$('#data-table').find('input[type="checkbox"]').change(function(){
    var is_checked =  $(this).is(':checked')?true:false;
    var this_value = parseInt($(this).val());
    var check = jQuery.inArray(this_value,data_return.data_id_checked)<0?true:false; //false
    
    if(is_checked==true){
        if(check==true){
            data_return.data_id_checked.push(this_value);
        } 
    }else{
        if(check==0){
            data_return.data_id_checked = data_return.data_id_checked.filter(function (d) { return d != this_value; });
        }
    }    
    $(this).parents('tr').toggleClass('active');
    show_data_table_action();
    $('#data-table-count').html(data_return.data_id_checked.length);
    $('#id_executed').val(data_return.data_id_checked);  
});

/** Hàm ẩn hiện phần thao tác nhanh */
function show_data_table_action(is_active){
    is_active = data_return.data_id_checked.length>0?true:false;
    if(is_active==true){
        $('#data-table-field').addClass('op0');
        $('#data-table-action').removeClass('hidden').addClass('fix-thead');
    }else{
        $('#data-table-field').removeClass('op0');
        $('#data-table-action').addClass('hidden');
    }
}

/** Hàm checkall trên table trang danh sách **/
$('#data-table-checkbox').change(function(){
    var is_checked =  $(this).is(':checked')?true:false;
    //var data_return = checked_on_table(true,is_checked);
    //console.log(data_return);
    $('#data-table>tr').find('input[type="checkbox"]').map(function(){
         var status = $(this).is(':checked')?1:0;
         var this_value = parseInt($(this).val());
         var check = jQuery.inArray(this_value,data_return.data_id_checked)<0?true:false;         
         
         boostrap_checkbox(this,is_checked);
         
         if(status==1){
            data_return.checked_on_table = true;
            if(check==true){
                data_return.data_id_checked.push(this_value);
            } 
            data_return.count = data_return.count + 1;
            return $(this).val(); 
         }
    });  
});

/** hàm xử lý checked của checkbox */
function boostrap_checkbox(input,checked){
    if(checked==true){
        if($(input).is(':checked')==0){
            $(input).click();
        }
    }else if(checked==false){
        if($(input).is(':checked')==1){
            $(input).click();
        }
    }
}

/** Hàm xử lý sự kiện change sort_data */
function th_sort_change(this_th){
    data_table_th_reset(this_th);
    var class_name = $(this_th).attr('class'),
        class_new = '';
    
    if(class_name == 'sorting_asc'){
        class_new = 'sorting_desc';
    }else if(class_name == 'sorting_desc'){
        class_new = 'sorting_asc';
    }else{
        class_new = 'sorting_asc';
    }
    $(this_th).attr('class',class_new);
}

function data_table_th_reset(th){
    var class_ = $(th).attr('class');
    $('#data-table-field').find('th').map(function(){
        $(this).removeAttr('status');              
        var class_hidden = $(this).hasClass('hidden');
        $(this).attr('class','sorting');  
        if(class_hidden==true){
            $(this).addClass('hidden');
        }
    });
    $(th).attr('status','active');
    $(th).attr('class',class_);
    
}
/** EXPORT */

function print(){
    var data_field = export_return_field();
    var data_list = export_return_list(data_field.count,'non_html');
    var data_table = $('#table_executed').val();
    var data = {
            field: data_field.field,
            list: data_list
        };
    if(data_list.length==0){
        load_toastr('Không có dữ liệu cần xuất','','warning');
        return;
    }
        
    var ajax = $.post(data_table+'/exportByPrint',data);
    
    ajax.error(function(){
        console.log('error_print'); 
    });
    
    ajax.success(function(data_return){
        data_return = jQuery.parseJSON(data_return);
        if(data_return.checkRole==false){
            create_popup('home/loadPopupViewRoleFalse');
            return;
        }
        //console.clear();
        var win = window.open( '', '' );
        win.document.close();
        win.document.write(data_return.html);
        
        setTimeout(print_action,500);
        function print_action(){
            win.print();
            win.close();
        }
        
    });
}
function pdf(){
    var data_field = export_return_field();
    var data_list = export_return_list(data_field.count,'non_html');
    var data_table = $('#table_executed').val();
    var data = {
            field: data_field.field,
            list: data_list
        };
    if(data_list.length==0){
        load_toastr('Không có dữ liệu cần xuất','','warning');
        return;
    }
    var ajax = $.post(data_table+'/pdf',data);
    
    ajax.error(function(){
        console.log('error_print'); 
    });
    ajax.success(function(data_return){
        data_return = jQuery.parseJSON(data_return);
        if(data_return.checkRole==false){
            create_popup('home/loadPopupViewRoleFalse');
            return;
        }

        var rawData = data_return.html;
        console.log(rawData);
        var i = 0;
        var numOfImageConverted = 0;
        var noImage = false;
        /*
        rawData.forEach(function (rowData, idx) {
            if (idx === 0) {
                return;
            }
            rowData.forEach(function(cellData, idx) {
                if (cellData.image !== undefined) {
                    noImage = true;
                     cellData.fit = [70,70];
                    //console.log(cellData.image);
                    //cellData.image = 'data:image/png;base64,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';
                    numOfImageConverted ++;                    
                    convertImgToBase64URL(cellData.image, function(base64data) {
                        numOfImageConverted --;
                        cellData.image = base64data;
                        cellData.fit = [70,70];
                        if (numOfImageConverted === 0) {
                            finish();
                        }
                    });
                    
                }
            });
            
        });*/
        finish();
        if(noImage == false){
            //finish();
        }
        
        function finish() {
            //console.log(rawData);return;
            //console.log(rawData);return;
            var data = {
                pageSize:"A4",
                pageOrientation:"portrait",
                
                content: [
    				{
    					table: {
    						headerRows: 1,
    						body: rawData
    					},
    					layout: 'noBorders',
    				}
    			],
                styles: {
    				tableHeader: {
    					bold: true,
    					fontSize: 11,
    					color: 'white',
    					fillColor: '#2d4154',
    					alignment: 'center'
    				},
    				tableBodyEven: {},
    				tableBodyOdd: {
    					fillColor: '#f3f3f3'
    				},
    				tableFooter: {
    					bold: true,
    					fontSize: 11,
    					color: 'white',
    					fillColor: '#2d4154'
    				},
    				title: {
    					alignment: 'center',
    					fontSize: 15
    				},
    				message: {}
    			},
    			defaultStyle: {
    				fontSize: 10
    			}
            };
            var pdf = window.pdfMake.createPdf( data );
            
            pdf.getBuffer( function (buffer) {
    			var blob = new Blob( [buffer], {type:'application/pdf;charset=UTF-8;'} );
                var name = $('#table_executed').val();
    			_saveAs( blob, name);
    		} );
        }      
    });
}

function convertImgToBase64URL(url, callback, outputFormat){
    var canvas = document.createElement('CANVAS'),
        ctx = canvas.getContext('2d'),
        img = new Image;
    img.crossOrigin = 'Anonymous';
    img.onload = function(){
        var dataURL;
        canvas.height = img.height;
        canvas.width = img.width;
        ctx.drawImage(img, 0, 0);
        dataURL = canvas.toDataURL(outputFormat);
        callback(dataURL);
        canvas = null; 
    };
    img.src = url;
}


function csv(){
    var data_field = export_return_field();
    var data_list = export_return_list(data_field.count,'non_html');
    var data = {
            field: data_field.field,
            list: data_list
        };
    // console.log(data_list.length);
    if(data_list.length==0){
        load_toastr('Không có dữ liệu cần xuất','','warning');
    }


    var ajax = $.post('product/exportByCsv',data);
    
    ajax.error(function(){
        console.log('error_csv');
    });
    
    ajax.success(function(data_return){
        data_return = jQuery.parseJSON(data_return);
        // console.log(data_return);return;
        if(data_return.checkRole==false){
            create_popup('home/loadPopupViewRoleFalse');
            return;
        }
        //console.clear();
        //console.log(html); return;
        var data = data_return.html;
        name = $('#table_executed').val();
        data = data.map(function (b) { return b.map(function (c) { return '"'+c+'"' }).join(","); }).join('\n');
        _saveAs(
    		new Blob( [data], {type: 'text/csv;charset=UTF-8'} ),name+".csv"
    	);
    });    
}

function export_return_field(){
    var data_field = [],
        count_field = 0;
    $('tr#data-table-field >th').map(function(){
        if($(this).hasClass('hidden')==false){
            var name = $(this).attr('data-name');
            data_field.push(name); 
            count_field++;
        }        
    });
    var data = {
            field:data_field,
            count:count_field
        };
    return data;
}

function export_return_list(count_field,type){
    var data_list = [];
    var html = [],
        i = 0,
        type = type==null?'html':'non_html';
    
    $('tbody#data-table >tr>td').map(function(){
        if($(this).hasClass('hidden')==false && $(this).hasClass('checkedbox')==false){
            var value = '';
            if(type=='non_html'){
                value = $(this).attr('data-value-export');
            }else{
                value = $(this).html();
            }            
            html.push(value);
            i++;
        }
        
        if(i==count_field){
            data_list.push(html);
            html = [];
            i = 0;
        }
    });
    return data_list;
}
/** END EXPORT */

$('.buttons-collection').click(function(){
    $('.dt-button-collection').toggleClass('hidden');
});

$('.dt-button-collection > a').click(function(){
    $(this).toggleClass('active');
    
    var field_selected = $(this).attr('data-field'),
        i = 1, //tổng số field, bắt đầu từ 1 vì loại trừ ô checkbox
        num = i, //vị trí field selected được tìm thấy
        temp_i = 0; //biến lưu tạm để foreach tbody
    
    $('#data-table-field >th').map(function(){
        if($(this).attr('data-field')==field_selected){
            $(this).toggleClass('hidden');
            num = i;
        }        
        i++;
    });
    
    $('#data-table >tr > td').map(function(){
         if(temp_i==num){
            $(this).toggleClass('hidden');
         }
         
         temp_i ++;
         if(temp_i==i){
            temp_i = 0;
         }
    });
});



/** hàm save trong file datatables.js */
var _saveAs = (function(view) {
	// IE <10 is explicitly unsupported
	if (typeof navigator !== "undefined" && /MSIE [1-9]\./.test(navigator.userAgent)) {
		return;
	}
	var
		  doc = view.document
		  // only get URL when necessary in case Blob.js hasn't overridden it yet
		, get_URL = function() {
			return view.URL || view.webkitURL || view;
		}
		, save_link = doc.createElementNS("http://www.w3.org/1999/xhtml", "a")
		, can_use_save_link = "download" in save_link
		, click = function(node) {
			var event = doc.createEvent("MouseEvents");
			event.initMouseEvent(
				"click", true, false, view, 0, 0, 0, 0, 0
				, false, false, false, false, 0, null
			);
			node.dispatchEvent(event);
		}
		, webkit_req_fs = view.webkitRequestFileSystem
		, req_fs = view.requestFileSystem || webkit_req_fs || view.mozRequestFileSystem
		, throw_outside = function(ex) {
			(view.setImmediate || view.setTimeout)(function() {
				throw ex;
			}, 0);
		}
		, force_saveable_type = "application/octet-stream"
		, fs_min_size = 0
		// See https://code.google.com/p/chromium/issues/detail?id=375297#c7 and
		// https://github.com/eligrey/FileSaver.js/commit/485930a#commitcomment-8768047
		// for the reasoning behind the timeout and revocation flow
		, arbitrary_revoke_timeout = 500 // in ms
		, revoke = function(file) {
			var revoker = function() {
				if (typeof file === "string") { // file is an object URL
					get_URL().revokeObjectURL(file);
				} else { // file is a File
					file.remove();
				}
			};
			if (view.chrome) {
				revoker();
			} else {
				setTimeout(revoker, arbitrary_revoke_timeout);
			}
		}
		, dispatch = function(filesaver, event_types, event) {
			event_types = [].concat(event_types);
			var i = event_types.length;
			while (i--) {
				var listener = filesaver["on" + event_types[i]];
				if (typeof listener === "function") {
					try {
						listener.call(filesaver, event || filesaver);
					} catch (ex) {
						throw_outside(ex);
					}
				}
			}
		}
		, auto_bom = function(blob) {
			// prepend BOM for UTF-8 XML and text/* types (including HTML)
			if (/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(blob.type)) {
				return new Blob(["\ufeff", blob], {type: blob.type});
			}
			return blob;
		}
		, FileSaver = function(blob, name) {
			blob = auto_bom(blob);
			// First try a.download, then web filesystem, then object URLs
			var
				  filesaver = this
				, type = blob.type
				, blob_changed = false
				, object_url
				, target_view
				, dispatch_all = function() {
					dispatch(filesaver, "writestart progress write writeend".split(" "));
				}
				// on any filesys errors revert to saving with object URLs
				, fs_error = function() {
					// don't create more object URLs than needed
					if (blob_changed || !object_url) {
						object_url = get_URL().createObjectURL(blob);
					}
					if (target_view) {
						target_view.location.href = object_url;
					} else {
						var new_tab = view.open(object_url, "_blank");
						if (new_tab === undefined && typeof safari !== "undefined") {
							//Apple do not allow window.open, see http://bit.ly/1kZffRI
							view.location.href = object_url;
						}
					}
					filesaver.readyState = filesaver.DONE;
					dispatch_all();
					revoke(object_url);
				}
				, abortable = function(func) {
					return function() {
						if (filesaver.readyState !== filesaver.DONE) {
							return func.apply(this, arguments);
						}
					};
				}
				, create_if_not_found = {create: true, exclusive: false}
				, slice
			;
			filesaver.readyState = filesaver.INIT;
			if (!name) {
				name = "download";
			}
			if (can_use_save_link) {
				object_url = get_URL().createObjectURL(blob);
				save_link.href = object_url;
				save_link.download = name;
				click(save_link);
				filesaver.readyState = filesaver.DONE;
				dispatch_all();
				revoke(object_url);
				return;
			}
			// Object and web filesystem URLs have a problem saving in Google Chrome when
			// viewed in a tab, so I force save with application/octet-stream
			// http://code.google.com/p/chromium/issues/detail?id=91158
			// Update: Google errantly closed 91158, I submitted it again:
			// https://code.google.com/p/chromium/issues/detail?id=389642
			if (view.chrome && type && type !== force_saveable_type) {
				slice = blob.slice || blob.webkitSlice;
				blob = slice.call(blob, 0, blob.size, force_saveable_type);
				blob_changed = true;
			}
			// Since I can't be sure that the guessed media type will trigger a download
			// in WebKit, I append .download to the filename.
			// https://bugs.webkit.org/show_bug.cgi?id=65440
			if (webkit_req_fs && name !== "download") {
				name += ".download";
			}
			if (type === force_saveable_type || webkit_req_fs) {
				target_view = view;
			}
			if (!req_fs) {
				fs_error();
				return;
			}
			fs_min_size += blob.size;
			req_fs(view.TEMPORARY, fs_min_size, abortable(function(fs) {
				fs.root.getDirectory("saved", create_if_not_found, abortable(function(dir) {
					var save = function() {
						dir.getFile(name, create_if_not_found, abortable(function(file) {
							file.createWriter(abortable(function(writer) {
								writer.onwriteend = function(event) {
									target_view.location.href = file.toURL();
									filesaver.readyState = filesaver.DONE;
									dispatch(filesaver, "writeend", event);
									revoke(file);
								};
								writer.onerror = function() {
									var error = writer.error;
									if (error.code !== error.ABORT_ERR) {
										fs_error();
									}
								};
								"writestart progress write abort".split(" ").forEach(function(event) {
									writer["on" + event] = filesaver["on" + event];
								});
								writer.write(blob);
								filesaver.abort = function() {
									writer.abort();
									filesaver.readyState = filesaver.DONE;
								};
								filesaver.readyState = filesaver.WRITING;
							}), fs_error);
						}), fs_error);
					};
					dir.getFile(name, {create: false}, abortable(function(file) {
						// delete file if it already exists
						file.remove();
						save();
					}), abortable(function(ex) {
						if (ex.code === ex.NOT_FOUND_ERR) {
							save();
						} else {
							fs_error();
						}
					}));
				}), fs_error);
			}), fs_error);
		}
		, FS_proto = FileSaver.prototype
		, saveAs = function(blob, name) {
			return new FileSaver(blob, name);
		}
	;
	// IE 10+ (native saveAs)
	if (typeof navigator !== "undefined" && navigator.msSaveOrOpenBlob) {
		return function(blob, name) {
			return navigator.msSaveOrOpenBlob(auto_bom(blob), name);
		};
	}

	FS_proto.abort = function() {
		var filesaver = this;
		filesaver.readyState = filesaver.DONE;
		dispatch(filesaver, "abort");
	};
	FS_proto.readyState = FS_proto.INIT = 0;
	FS_proto.WRITING = 1;
	FS_proto.DONE = 2;

	FS_proto.error =
	FS_proto.onwritestart =
	FS_proto.onprogress =
	FS_proto.onwrite =
	FS_proto.onabort =
	FS_proto.onerror =
	FS_proto.onwriteend =
		null;

	return saveAs;
}(window));


/** CONFIG */
var mapGeocoding = function () {
    var maplat = $('input[name="googlemap_lat"]').val(),
        maplng = $('input[name="googlemap_lng"]').val(),
        map = new GMaps({
            div: '#gmap_geocoding',
            lat: maplat,
            lng: maplng,
            zoom:15
        });
        
    map.addMarker({lat:maplat,lng:maplng});
    $('#gmap_geocoding').css('width','100%');
    $('#gmap_geocoding').css('height','300');
    var handleAction = function () {
        
        var text = $.trim($('#gmap_geocoding_address').val());
        GMaps.geocode({
            address: text,
            callback: function (results, status) {
                if (status == 'OK') {
                    for (var i = 0; i < map.markers.length; i++) {
                        map.markers[i].setMap(null);
                    }


                    var latlng = results[0].geometry.location;
                    map.setCenter(latlng.lat(), latlng.lng());
                    maplat = latlng.lat(); /** set value */
                    maplng = latlng.lng(); /** set value */
                    
                    map.addMarker({
                        lat: latlng.lat(),
                        lng: latlng.lng(),
                        draggable: true,
                        dragend:function(marker){
                            maplat = marker.latLng.lat();
                            maplng = marker.latLng.lng();
                            set_input_value(maplat,maplng);
                        }
                    });
                    set_input_value(maplat,maplng);
                    //App.scrollTo($('#gmap_geocoding'));
                }
            }
        });
    }
    
    var set_input_value = function(lat,lng){
        $('input[name="googlemap_lat"]').val(lat);
        $('input[name="googlemap_lng"]').val(lng)
    }

    $('#gmap_geocoding_btn').click(function (e) {
        e.preventDefault();
        handleAction();
    });

    $("#gmap_geocoding_address").keypress(function (e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            e.preventDefault();
            handleAction();
        }
    });
}
var load_map_tab = false;
/** load editor.init and map when change tab */
$('ul.nav-tabs li').click(function(){
    var id = $(this).attr('id');
    if(id=='config_googlemap' && load_map_tab==false){
        setTimeout(mapGeocoding,500);
        load_map_tab = true;
    } 
    reload_editor();
});
/** END CONFIG */

/** TAG AUTOCOMPLETE */
var tag_array = [];
function tag_autocomplete_create(){    
    $('.tag_autocomplete').each(function(){
        var id_input = '#'+$(this).attr('id');
        tag_autocomplete_create_one(id_input);
    });
}

function tag_autocomplete_create_one(input_id){
    
    var jsonData = jQuery.parseJSON($(input_id).attr('data-value')),
        jsonData_select = [],
        inputName = $(input_id).attr('name');
    
    for(var key in jsonData){
        if(jsonData[key]["selected"]==true){
            jsonData_select.push({
                id: jsonData[key]["id"],
                name: jsonData[key]["name"]
            });
        }
    }
    
    var tag = $(input_id).tagSuggest({
        data: jsonData,
        sortOrder: 'name',
        maxDropHeight: 200,
        name: inputName
    });
    tag.addToSelection(jsonData_select);
    tag_array.push({tag});
    
    
}
/** Add Tag: popup chỉnh sửa tag ở trang danh sách */
function add_tag(this_input){
    var id_input = $(this_input).attr('data-tag');

    /** find Tag in tag_array */
    var tag;
    for(var key in tag_array){
        if(key!='remove'){
            /** get ID tag */
            var this_id_input = tag_array[key].tag.container[0].id;
            if(this_id_input==id_input){
                tag = tag_array[key].tag;
            }
        }
    }
    var jsonData = jQuery.parseJSON($(this_input).attr('data-value'));
    tag.addToSelection(jsonData);
}

/** END TAG AUTOCOMPLETE */

