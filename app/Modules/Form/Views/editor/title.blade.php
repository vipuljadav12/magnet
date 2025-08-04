<div class="card-header col-12">	
	<i class="{{$field->icon ?? ""}}"></i> <span>{{ucwords($field->name) ?? ""}}</span>
</div>
<div class="col-12 m-t-5 editor-col-spaces p-10">
	<label class="m-b-5">Field Name</label>
	<br>
	@foreach($languages as $lang)
		<label class="text-info">{{$lang->language}}</label>
		<input type="text" name="label_{{$lang->language_code}}" class="form-control editorInput" data-for="label_{{$lang->language_code}}" build-id="{{$build->id}}" value="{{getContentLabelValue($build->id, 'label_'.$lang->language_code) ?? ""}}">
	@endforeach
</div>