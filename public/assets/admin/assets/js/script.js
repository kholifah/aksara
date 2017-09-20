jQuery(document).ready(function($) {
	/* Image Preview */
	$(".file").bind("change", function() {
		var file = this.files[0];
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		var imagePreview = $(this).closest(".form-img").find(".image-preview");
		var previewing = $(this).closest(".form-img").find(".previewing");
		var info = $(this).closest(".form-img").find(".info");
		var infoError = $(this).closest(".form-img").find(".info-error");

		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			$(this).closest(".form-img").addClass("preview");
			imagePreview.hide();	
			previewing.attr("src", "");
			info.hide();
			infoError.show();
		} else {
			var reader = new FileReader();
			reader.onload = function (e) {
				$(this).closest(".form-img").addClass("preview");
				previewing.attr("src", e.target.result);
				imagePreview.show();
				info.show();
				infoError.hide();

				setTimeout(function() {
					var widthImg = previewing.width();
					imagePreview.width(widthImg);
				}, 500);	
			};
			reader.readAsDataURL(this.files[0]);
		}
	});

	$(".image-preview .img-remove").bind("click", function(e) {
		$(this).closest(".form-img").removeClass("preview");
		$(this).closest(".form-img").find(".file").val("");
		$(this).closest(".form-img").find(".image-preview").hide();	
		$(this).closest(".form-img").find(".info").hide();	

		e.preventDefault();
	});

	/* Select All */
	$(".checkall input[type=checkbox]").on("change", function() {
		$(this).closest(".table, .checkbox-role").find(".checkbox input[type=checkbox]").prop("checked", $(this).prop("checked"));
	});

	$(".table, .checkbox-role").find(".checkbox:not(.checkall) input[type=checkbox]").on("change", function() {
		var checkbox = $(this).closest(".table, .checkbox-role").find(".checkbox:not(.checkall) input[type=checkbox]").length;
		var checked = $(this).closest(".table, .checkbox-role").find(".checkbox:not(.checkall) input[type=checkbox]:checked").length;

		if(checkbox == checked) {
			$(this).closest(".table, .checkbox-role").find(".checkall input[type=checkbox]").prop("checked", true);
		} else {
			$(this).closest(".table, .checkbox-role").find(".checkall input[type=checkbox]").removeAttr("checked");
		}
	});

	/* Custom Scroll */
	$(".js-scroll").slimScroll({
		height: "auto",
		size: "3px",
		railVisible: true
	}).siblings(".slimScrollBar").hide();

	/* Repeatable
	----------------------------------------------------------- */
	$('.repeat-trigger').on('click', function(e) {
		var elm = $(this);
		var max = $(this).data('max');

		repeatable(elm, max);
		e.preventDefault();
	});
	$('.repeat-trigger-submenu-2').on('click', function(e) {
		var elm = $(this);
		var max = $(this).data('max');

		repeatableSub(elm, max);

		e.preventDefault();
		e.stopPropagation(true);
	});

	$('.repeat-trigger-submenu-3').on('click', function(e) {
		var elm = $(this);
		var max = $(this).data('max');

		repeatableSub2(elm, max);

		e.preventDefault();
		e.stopPropagation(true);
	});

	$(document).bind('repeatsub-on-clone', function(event, clone, thatElm) {
		clone.addClass('item-box__depth-1');
		clone.find('.repeat-trigger-submenu-3').show();
		clone.find('.repeat-trigger-submenu-2').hide();	
		clone.find('.item-box--title > span').html("Sub Menu Item Level 2");	
	});

	$('.repeat-delete').on('click', function(e) {
		var elm = $(this);
		var max = $(this).data('max');
		repeatableDelete(elm, max);
		e.preventDefault();
	});

	$(document).bind('repeat-on-clone', function(event, clone, thatElm) {
		// Code Editor
		if(clone.find(".code-editor").length) {
			clone.find(".code-editor").each(function(index, elem) {
				var that = $(this);
				var cm = CodeMirror.fromTextArea(elem, { 
					textWrapping: true,
					lineNumbers: true,
					styleActiveLine: true,
					matchBrackets: true,
					theme: "blackboard"
				});

				setTimeout(function() {
					cm.refresh();
				}, 100);		        

				$(window).on("toggleShowMore", function() {
					cm.refresh();
				});

				if($(this).closest(".repeatable-base").length) {
					cm.toTextArea();
				}
			});
		}
		clone.find('.item-box--more').show();
		// clone.find('.item-box--title').html("---");
		clone.find(".fa-angle-down").addClass("fa-rotate-180");
	});

	// toggle show more
	$(".toggle-showmore").on("click", function(e) {
		$(this).closest(".item-box").find(".item-box--more").slideToggle();
		$(this).find(".fa-angle-down").toggleClass("fa-rotate-180");
		$(window).trigger("toggleShowMore");

		e.preventDefault();
	});

	$(".form-item-title").on("change", function(e) {
		var title = $(this).val();
		$(this).closest(".item-box").find(".item-box--title").html(title);
	});

	// Code Editor
	if($(".code-editor").length) {
		$(".code-editor:not(cm-rendered)").each(function(index, elem) {
			var that = $(this);
			var cm = CodeMirror.fromTextArea(elem, { 
				textWrapping: true,
				lineNumbers: true,
				styleActiveLine: true,
				matchBrackets: true,
				theme: "ambiance"
			});

			$(window).on("toggleShowMore", function() {
				cm.refresh();
			});

			if($(this).closest(".repeatable-base").length) {
				cm.toTextArea();
			}
		});
	}

	/* Hashchange
	------------------------------------------------------ */
	$('.nav-pills [data-toggle="pill-hashchange"]').click(function() {
		$(this).closest('.nav-pills').children().removeClass('active');
		$(this).parent().addClass('active');

		$(window).on('hashchange', function(){
			var target = window.location.hash;

			$('.tab-pane').removeClass('active');
			$('.tab-pane' + target).addClass('active');
		});
	});

	if($('.js-hashchange').length) {
		var target = window.location.hash;
		$('.tab-pane').removeClass('active');
		$('.tab-pane' + target).addClass('active');

		$('.nav-pills').children().removeClass('active');
		$('.nav-pills').find('a[href='+target+']').parent().addClass('active');
	}

	/* Edit slug
	------------------------------------------------------- */
	$('#edit-slug-buttons .edit-slug').on('click', function() {
		var editBtn = $(this).clone(true);
		var okBtn = '<button type="button" class="save-slug btn btn-secondary">OK</button>';
		var cancelBtn = '<button type="button" class="cancel-slug btn btn-danger">Cancel</button>';
		var link_base_url = $('.sample-permalink > a');
		var base_url = $('.sample-permalink > a').html();
		var span_base_url = '<span>'+base_url+'</span>';
		var current_slug = $('#new-post-slug').val();

		$(this).parent().append(okBtn + cancelBtn);
		$(this).remove();
		$('.sample-permalink').prepend(span_base_url);
		$('.sample-permalink > a').remove();
		$('#new-post-slug').show();
		$('#editable-post-name').hide();

		$('.save-slug').on('click', function() {
			var new_slug = $('#new-post-slug').val();

			$(this).parent().append(editBtn);
			$(this).parent().find('.save-slug, .cancel-slug').remove();
			$('.sample-permalink').prepend(link_base_url);
			$('.sample-permalink > span').remove();
			$('#new-post-slug').hide();
			$('#editable-post-name').show().html(new_slug + '/');
		});
		$('.cancel-slug').on('click', function() {
			$(this).parent().append(editBtn);
			$(this).parent().find('.save-slug, .cancel-slug').remove();
			$('.sample-permalink').prepend(link_base_url);
			$('.sample-permalink > span').remove();
			$('#new-post-slug').val(current_slug).hide();
			$('#editable-post-name').show();
		});
	});

	/* Tag Generator
	------------------------------------------------------- */
	$('.tag-generator > .btn').click(function(e) {
		var type = $(this).data('type');
		var text = '<input type="text" class="form-control">\n';
		var email = '<input type="email" class="form-control">\n';
		var url = '<input type="url" class="form-control">\n';
		var tel = '<input type="tel" class="form-control">\n';
		var number = '<input type="number" class="form-control">\n';
		var textarea = '<textarea class="form-control"></textarea>\n';
		var dropdown = '<select class="form-control">\n  <option value="Opsi 1">Opsi 1</option>\n  <option value="Opsi 2">Opsi 2</option>\n  <option value="Opsi 3">Opsi 3</option>\n</select>\n';
		var checkbox = '<div class="checkbox">\n  <label><input type="checkbox" value="">Option 1</label>\n</div>\n';
		var radio = '<div class="radio">\n  <label><input type="radio" name="optradio">Option 1</label>\n</div>\n';
		var file = '<input type="file" class="form-control">\n';
		var submit = '<input type="submit" class="btn btn-primary">\n';

		if(type == 'text') {
			$('#generator-area').insertAtCaret( text );
		}
		if(type == 'email') {
			$('#generator-area').insertAtCaret( email );
		}
		if(type == 'url') {
			$('#generator-area').insertAtCaret( url );
		}
		if(type == 'tel') {
			$('#generator-area').insertAtCaret( tel );
		}
		if(type == 'number') {
			$('#generator-area').insertAtCaret( number );
		}
		if(type == 'textarea') {
			$('#generator-area').insertAtCaret( textarea );
		}
		if(type == 'dropdown') {
			$('#generator-area').insertAtCaret( dropdown );
		}
		if(type == 'checkbox') {
			$('#generator-area').insertAtCaret( checkbox );
		}
		if(type == 'radio') {
			$('#generator-area').insertAtCaret( radio );
		}
		if(type == 'file') {
			$('#generator-area').insertAtCaret( file );
		}
		if(type == 'submit') {
			$('#generator-area').insertAtCaret( submit );
		}

		e.preventDefault();
	});
});

/* Repeatable Function
----------------------------------------------------------- */
function repeatable(elm, max) {
	if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
		elm.closest('.repeat-wrap').find('.repeat-trigger').attr('disabled', true);
	} else {
		var clone = elm.closest('.repeat-wrap').find('.repeatable-base').clone(true, true).addClass('repeat-clone repeatable');
		elm.closest('.repeat-wrap').append(clone);
		elm.closest('.repeat-wrap').find('.repeat-clone .repeat-delete').removeClass('hidden');
		elm.closest('.repeat-wrap').find('.repeat-clone').removeClass('repeatable-base');

		if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
			elm.closest('.repeat-wrap').find('.repeat-trigger').attr('disabled', true);
		}

		var repeatClone = clone;
		$(document).trigger('repeat-on-clone', [repeatClone, elm]);
	}
}
function repeatableSub(elm, max) {
	if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
		elm.closest('.repeat-wrap').find('.repeat-trigger').attr('disabled', true);
	} else {
		var clone = elm.closest('.repeat-wrap').find('.repeatable-base').clone(true, true).addClass('repeat-clone repeatable');		

		if(elm.closest('.repeatable').next('.submenu-wrap').length) {
			elm.closest('.repeatable').next('.submenu-wrap').append(clone);
		} else {
			var subWrap = '<div class="submenu-wrap"></div>'
			$(subWrap).insertAfter(elm.closest('.repeatable'));

			elm.closest('.repeatable').next('.submenu-wrap').append(clone);
		}

		elm.closest('.repeat-wrap').find('.repeat-clone .repeat-delete').removeClass('hidden');
		elm.closest('.repeat-wrap').find('.repeat-clone').removeClass('repeatable-base');

		if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
			elm.closest('.repeat-wrap').find('.repeat-trigger').attr('disabled', true);
		}

		var repeatClone = clone;
		elm.triggerAll('repeat-on-clone repeatsub-on-clone', [repeatClone, elm]);
	}
}

function repeatableSub2(elm, max) {
	if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
		elm.closest('.repeat-wrap').find('.repeat-trigger').attr('disabled', true);
	} else {
		var clone = elm.closest('.repeat-wrap').find('.repeatable-base').clone(true, true).addClass('repeat-clone repeatable');

		if(elm.closest('.repeatable').next('.submenu2-wrap').length) {
			elm.closest('.repeatable').next('.submenu2-wrap').append(clone);
		} else {
			var subWrap = '<div class="submenu2-wrap"></div>'
			$(subWrap).insertAfter(elm.closest('.repeatable'));

			elm.closest('.repeatable').next('.submenu2-wrap').append(clone);
		}
		elm.closest('.repeat-wrap').find('.repeat-clone .repeat-delete').removeClass('hidden');
		elm.closest('.repeat-wrap').find('.repeat-clone').removeClass('repeatable-base');

		if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
			elm.closest('.repeat-wrap').find('.repeat-trigger').attr('disabled', true);
		}
	}

	clone.addClass('item-box__depth-2');
	clone.find('.repeat-trigger-submenu-3, .repeat-trigger-submenu-2').hide();
	$(document).trigger('repeat-on-clone', [clone, elm]);
	clone.find('.item-box--title > span').html("Sub Menu Item Level 3");	
}

function repeatableDelete(elm, max) {
	var repeat_wrap = elm.closest('.repeat-wrap');
	elm.closest('.repeatable').remove();

	if(elm.closest('.repeat-wrap').find('.repeatable').length >= max) {
		repeat_wrap.find('.repeat-trigger').attr('disabled', true);
	} else {
		repeat_wrap.find('.repeat-trigger').removeAttr('disabled');
	}
}

/* Multi Trigger */
(function($) {
	$.fn.extend({
		triggerAll: function (events, params) {
			var el = this, i, evts = events.split(' ');
			for (i = 0; i < evts.length; i += 1) {
				el.trigger(evts[i], params);
			}
			return el;
		}
	});

	$.fn.extend({
		insertAtCaret: function(myValue){
			return this.each(function(i) {
				if (document.selection) {
					//For browsers like Internet Explorer
					this.focus();
					var sel = document.selection.createRange();
					sel.text = myValue;
					this.focus();
				} else if (this.selectionStart || this.selectionStart == '0') {
					//For browsers like Firefox and Webkit based
					var startPos = this.selectionStart;
					var endPos = this.selectionEnd;
					var scrollTop = this.scrollTop;
					this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
					this.focus();
					this.selectionStart = startPos + myValue.length;
					this.selectionEnd = startPos + myValue.length;
					this.scrollTop = scrollTop;
				} else {
					this.value += myValue;
					this.focus();
				}
			});
		}
	});
})(jQuery);