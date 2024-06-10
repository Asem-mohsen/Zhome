@php
    $featureIndex = $index ?? 0;
    $feature = $feature ?? null;
@endphp

<div class="row feature-form position-relative">
    <div class="col-md-6">
        <div class="form-group">
            <label for="Feature" class="form-control-label">Feature</label>
            <input class="form-control" type="text" id="Feature" name="features[{{ $featureIndex }}][Feature]" value="{{ $feature->Feature ?? '' }}" required>
        </div>
        @error('Feature')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="Brand-logo">Image</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" name="features[{{ $featureIndex }}][Feature-Image]" class="custom-file-input" id="Feature-Image">
                    <label class="custom-file-label" for="Feature-Image">Choose file</label>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                </div>
            </div>
        </div>
        @error('Feature-Image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="Feature-Description">Description</label>
            <textarea class="form-control" rows="3" name="features[{{ $featureIndex }}][Feature-Description]" placeholder="Enter ...">{{ $feature->Description ?? '' }}</textarea>
        </div>
        @error('Feature-Description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="EndDate">Ends In</label>
            <input class="form-control" type="date" name="features[{{ $featureIndex }}][EndDate]" id="EndDate" value="{{ $feature->EndDate ?? '' }}">
        </div>
        @error('EndDate')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <span class="delete-icon">&times;</span>
</div>