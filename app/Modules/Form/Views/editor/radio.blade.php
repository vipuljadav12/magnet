<style type="text/css">
	
</style>
<div class="row editorBox">
	@include("Form::editor.title")
	{{-- <div class="col-12 m-t-5">
		<label class="m-b-5">Field Name</label>
		<br>
		@foreach($languages as $lang)
			<label class="text-info">{{$lang->language}}</label>
			<input type="text" name="label_{{$lang->language_code}}" class="form-control editorInput" data-for="label_{{$lang->language_code}}" build-id="{{$build->id}}" value="{{getContentLabelValue($build->id, 'label_'.$lang->language_code) ?? ""}}">
		@endforeach
	</div> --}}
	<div class="col-12 m-t-5">
		<label class="m-b-5">Dependent Field</label>
		<input type="text" name="dependent_field" class="form-control editorInput" data-for="dependent_field" build-id="{{$build->id}}" value="{{getContentValue($build->id,"dependent_field") ?? ""}}">
	</div>
	
	<div class="col-12 m-t-5 optionBox">
		<label class="m-b-5">Options</label>
		<div class="{{-- d-flex align-items-center  --}}m-t-5">
			@php
				$currentOptions = getContentRadio($build->id);
				$count = 0;
			@endphp
			@if(isset($currentOptions) && !empty($currentOptions))
				@foreach($currentOptions as $c=>$currentOption)					
					<div class="row m-t-5">
						<div class="col-6">
							<input type="text" name="{{$currentOption->field_property}}" class="form-control editorInput radioboxList"  data-for="{{$currentOption->field_property}}" build-id="{{$build->id}}" value="{{getContentValue($build->id,$currentOption->field_property) ?? ""}}">
						</div>
						<div class="col-6">
							<a class="btn text-primary addMoreRadio"><i class="fa fa-plus"></i></a>
							<a class="btn text-primary removeMoreRadio"  content-id="{{$currentOption->id}}"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					@php $count = $count + 1; @endphp
				@endforeach
			@endif
			@if($count == 0)
				<div class="row m-t-5">
					<div class="col-6">
						<input type="text" name="radio_1" class="form-control  editorInput radioList"  data-for="radio_1" build-id="{{$build->id}}" value="{{getContentValue($build->id,"radio_1") ?? ""}}">
					</div>
					<div class="col-6">
						<a class="btn text-primary addMoreRadio"><i class="fa fa-plus"></i></a>
						<a class="btn text-primary d-none removeMoreRadio"><i class="fa fa-minus"></i></a>
					</div>
				</div>
			@endif
		</div>
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