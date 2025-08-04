<div class="row editorBox">
	@include("Form::editor.title")
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Title Text</label>
		<input type="text" name="label" class="form-control editorInput" data-for="label" build-id="{{$build->id}}" value="{{getContentValue($build->id,"label") ?? ""}}">
	</div>
	
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">First Option Title Text</label>
		<input type="text" name="first_option_text_title" class="form-control editorInput" data-for="first_option_text_title" build-id="{{$build->id}}" value="{{getContentValue($build->id,"first_option_text_title") ?? ""}}">
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Second Option Title Text</label>
		<input type="text" name="second_option_text_title" class="form-control editorInput" data-for="second_option_text_title" build-id="{{$build->id}}" value="{{getContentValue($build->id,"second_option_text_title") ?? ""}}">
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Second Program Display</label>
		<select class="form-control editorInput " name="second_display" data-for="second_display"  build-id="{{$build->id}}">
			<option value="yes" @if(getContentValue($build->id,"second_display") != null && getContentValue($build->id,"second_display") == "yes") selected @endif>Yes</option>
			<option value="no" @if(getContentValue($build->id,"second_display") != null && getContentValue($build->id,"second_display") == "no") selected @endif>No</option>

		</select>
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Sibling Display</label>
		<select class="form-control editorInput " name="sibling_display" data-for="sibling_display"  build-id="{{$build->id}}">
			<option value="yes" @if(getContentValue($build->id,"sibling_display") != null && getContentValue($build->id,"sibling_display") == "yes") selected @endif>Yes</option>
			<option value="no" @if(getContentValue($build->id,"sibling_display") != null && getContentValue($build->id,"sibling_display") == "no") selected @endif>No</option>

		</select>
	</div>
	

	@include("Form::editor.common")
</div>