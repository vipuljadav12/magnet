<div class="row editorBox">
	
	
	<div class="col-12 m-t-5">
		<label class="m-b-5">Description Text</label>
		<textarea name="value" class="form-control editorInput"  data-for="value" build-id="{{$build->id}}" value="{{getContentValue($build->id,"value") ?? ""}}"></textarea>
	</div>
	<div class="col-12 m-t-5">
		<label class="m-b-5">Background Class</label>
		<select name="alert-class" class="form-control editorInput"  data-for="alert-class" build-id="{{$build->id}}">
			<option value="alert-success">Green</option>
			<option value="alert-danger">Red</option>
			<option value="alert-warning">Orange</option>
			<option value="alert-info">Blue</option>
		</select>
	</div>
	@include("Form::editor.common")
</div>