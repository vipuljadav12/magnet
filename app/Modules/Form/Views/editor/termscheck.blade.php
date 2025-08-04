<style type="text/css">
	
</style>
<div class="row editorBox">
	@include("Form::editor.title")
	<div class="col-12 m-t-5 optionBox">
		<label class="m-b-5">Text</label>
		<br>
		@foreach($languages as $lang)
			<label class="text-info">{{$lang->language}}</label>
			<div class="{{-- d-flex align-items-center  --}}m-t-5">
				@php
					$currentOptions = getContentValue($build->id,"checkbox_1_".$lang->language_code);
					if($currentOptions == "")
						$currentOptions = getContentValue($build->id,"checkbox_1");

				@endphp
				<textarea name="checkbox_1_{{$lang->language_code}}" class="form-control editorInput termtext" data-for="checkbox_1_{{$lang->language_code}}" build-id="{{$build->id}}">{{$currentOptions}}</textarea>
			</div>
		@endforeach


		
	</div>
	<div class="col-12 m-t-5 editor-col-spaces p-10">
		<label class="m-b-5">Title Texts</label>
		<br>
		@foreach($languages as $lang)
			<label class="text-info m-t-5">{{$lang->language}}</label>
			<div class="">
				<input type="text" name="placeholder_{{$lang->language_code}}" class="form-control editorInput"  data-for="placeholder_{{$lang->language_code}}" build-id="{{$build->id}}" value="{{getContentValue($build->id,'placeholder_'.$lang->language_code) ?? getContentValue($build->id,'placeholder')}}">
			</div>
		@endforeach
	</div>
	{{-- <div class="col-12 m-t-5 mb10 m-b-5">
		@php
			$required = getContentValue($build->id,"required");
			$v = isset($required) ?  "checked" : "";
		@endphp
		<label class="m-b-5">Required</label>
		<input type="checkbox" name="required" class="editorInput js-switch" {{$v}}  data-for="required" build-id="{{$build->id}}">
	</div>
	<div class="col-12 m-t-5">
		<div class="text-right">
			<button class="btn btn-success "><i class="fa fa-save"></i></button>
		</div>
	</div> --}}
	@include("Form::editor.common")
</div>