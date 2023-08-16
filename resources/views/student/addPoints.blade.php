@extends('layouts.dashboard')
@section('title')
    {{__('User')}}
@endsection
@section('sub-title','Add Point')
@section('content')
    <style>
        .inline-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .inline-row select, .inline-row input[type="text"] {
            margin-right: 10px;
        }

        .inline-row button {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::button('+', ['type' => 'button', 'class' => 'btn btn-primary add', 'id' => 'addRowButton']) !!}

    {!! Form::open(['route' => 'student.save-points', 'method' => 'POST']) !!}
    {!! Form::hidden('student_id', $student->id) !!}
    <div class="body" id="Body">
    </div>
    {!! Form::submit(__('Lưu điểm'), ['class' => 'btn btn-primary pull-right', 'id' => 'saveScoreButton']) !!}
    {!! Form::close() !!}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var limit = {{ count($subject)}};
            var clickLimit = $('.select-point .subject').length;
            var optionValue = getOptionSelected();

            disableButton(clickLimit, limit);
            filterSubject(optionValue);

            $('.body').on('click', '.deleteRowButton', function () {
                $(this).closest('.inline-row').remove();
                updateClickLimit(-1);
            });

            $('.add').on('click', function () {
                updateClickLimit(1);
                disableButton(clickLimit, limit);

                var html = `<div class="inline-row">
                {!! Form::select('subject_id[]', ['' => '-- Chọn môn học --'] + $subject->pluck('name', 'id')->toArray(), null, ['class' => 'form-control subject']) !!}
                {!! Form::number('point[]', null, ['class' => 'form-control point-input', 'placeholder' => __('Point')]) !!}
                <button type="button" class="btn btn-danger deleteRowButton">X</button>
                <div class="error-message"></div>
            </div>`;

                $('#Body').append(html);
                updateOptionValue();
                filterSubject(optionValue);
            });

            // render điểm theo đúng select option
            $('.body').on('change', '.subject', function () {
                var $thisRow = $(this).closest('.inline-row');
                var selectedSubjectId = $(this).val();

                var studentSubjects = @json($student->studentSubjects);

                var matchingSubject = studentSubjects.find(function (subject) {
                    return subject.subject_id == selectedSubjectId;
                });

                if (matchingSubject) {
                    $thisRow.find('.point-input').val(matchingSubject.point);
                } else {
                    $thisRow.find('.point-input').val('');
                }

                updateOptionValue();
                filterSubject(optionValue);
            });

            function getOptionSelected() {
                return $('.body .subject option:selected').map(function () {
                    return $(this).val();
                }).get();
            }

            function disableButton(clickLimit, limit) {
                $('.add').prop('disabled', clickLimit === limit);
            }

            function updateClickLimit(value) {
                clickLimit += value;
                disableButton(clickLimit, limit);
            }

            function updateOptionValue() {
                optionValue = getOptionSelected();
            }

            function filterSubject(e) {
                $('.subject').each(function () {
                    $(this).find('option').each(function () {
                        $(this).toggle($.inArray($(this).val(), e) === -1);
                    });
                });
            }
        });
    </script>




































    <script>
        {{--var addedRows = 0; // Initialize the counter--}}
        {{--var maxRows = @json(count($subject->pluck('name', 'id')->toArray()));--}}

        {{--$('#addRowButton').click(function () {--}}
        {{--    // var newRow = $('#inputRowTemplate').clone(); // Clone the input row template--}}
        {{--    var html = `<div class="inline-row" id="inputRowTemplate">--}}
        {{--        {!! Form::select('subject_id[]', ['' => '-- Chọn môn học --'] + $subject->pluck('name', 'id')->toArray(), null, ['class' => 'form-control', 'onchange' => 'updateOptions(this)']) !!}--}}
        {{--        {!! Form::number('point[]', null, ['class' => 'form-control point-input', 'placeholder' => __('Point')]) !!}`+`--}}
        {{--        <button type="button" class="btn btn-danger deleteRowButton" onclick="deleteRow(this)">X</button>`+`--}}
        {{--        <div class="error-message"></div> <!-- Error message placeholder -->--}}
        {{--    </div>`;--}}
        {{--    // newRow.removeAttr('style'); // Show the cloned row--}}
        {{--    $('#Body').append(html);--}}
        {{--    addedRows++;--}}

        {{--    // Disable the button if the maximum number of rows is reached--}}
        {{--    if (addedRows >= maxRows) {--}}
        {{--        $('#addRowButton').prop('disabled', true);--}}
        {{--    }--}}
        {{--});--}}

        // Nút "Xóa"
        // $(document).on('click', '.deleteRowButton', function () {
        //     var row = $(this).closest('.inline-row');
        //     var select = row.find('select.form-control');
        //     var selectedValue = select.val();
        //
        //     if (selectedValue !== '') {
        //         // Show the selected option in other select elements
        //         $('select.form-control').each(function() {
        //             var otherSelect = $(this);
        //             otherSelect.find('option[value="' + selectedValue + '"]').show();
        //         });
        //
        //         // Remove the selected value from selectedOptions
        //         delete selectedOptions[selectedValue];
        //     }
        //
        //     row.remove();
        //     addedRows--;

        {{--    // Enable the button when a row is deleted--}}
        {{--    if (addedRows < maxRows) {--}}
        {{--        $('#addRowButton').prop('disabled', false);--}}
        {{--    }--}}
        {{--});--}}

        {{--var selectedOptions = [];--}}

        {{--var studentSubjects = @json($student->studentSubjects->keyBy('subject_id')->toArray());--}}

        {{--function updateOptions(selectElement) {--}}
        {{--    var selectedValue = selectElement.value; //id của option--}}
        {{--    var row = $(selectElement).closest('.inline-row');--}}
        {{--    var pointInput = row.find('.point-input');--}}
        {{--    var errorDiv = row.find('.error-message');--}}
        {{--    errorDiv.empty();--}}
        {{--    console.log(selectedValue, selectedOptions);--}}
        {{--    if (selectedValue !== '') {--}}
        {{--        if ($.inArray(selectedValue, selectedOptions) !== -1) {--}}
        {{--            console.log('hehee');--}}
        {{--            // Show an error or perform some action since the option is already selected--}}
        {{--        } else {--}}
        {{--            selectedOptions.push(selectedValue);--}}

        {{--            hideSelectedOption(selectedValue);--}}

        {{--            var studentSubject = studentSubjects[selectedValue];--}}
        {{--            if (studentSubject) {--}}
        {{--                pointInput.val(studentSubject.point);--}}
        {{--            } else {--}}
        {{--                pointInput.val('');--}}
        {{--            }--}}
        {{--        }--}}
        {{--    }--}}
        {{--    console.log(selectedOptions);--}}

        {{--    if (!selectedValue) {--}}
        {{--        errorDiv.html('Môn học là bắt buộc.');--}}
        {{--    }--}}

        {{--    if (!pointInput) {--}}
        {{--        errorDiv.html('Điểm số không được để trống.');--}}
        {{--    }--}}
        {{--}--}}

        {{--function hideSelectedOption(selectedValue) {--}}
        {{--    $('select.form-control').each(function() {--}}
        {{--        var select = $(this);--}}
        {{--        var options = select.find('option');--}}
        {{--        console.log(options);--}}
        {{--        options.show();--}}
        {{--        selectedOptions.forEach(function(option) {--}}
        {{--            select.find('option[value="' + option + '"]').hide();--}}
        {{--        });--}}
        {{--    });--}}
        {{--}--}}

        {{--function showSelectedOptions() {--}}
        {{--    $('select.form-control').each(function() {--}}
        {{--        var select = $(this);--}}
        {{--        var selectedValue = select.val();--}}
        {{--        if (selectedValue) {--}}
        {{--            select.find('option[value="' + selectedValue + '"]').show();--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        {{--function deleteRow(deleteButton) {--}}
        {{--    var row = $(deleteButton).closest('.inline-row');--}}
        {{--    var select = row.find('select.form-control');--}}
        {{--    var selectedValue = select.val();--}}

        {{--    if (selectedValue !== '') {--}}
        {{--        // Show the selected option in other select elements--}}
        {{--        $('select.form-control').each(function() {--}}
        {{--            var otherSelect = $(this);--}}
        {{--            otherSelect.find('option[value="' + selectedValue + '"]').show();--}}
        {{--        });--}}

        {{--        // Remove the selected value from selectedOptions--}}
        {{--        selectedOptions = selectedOptions.filter(function(option) {--}}
        {{--            return option !== selectedValue;--}}
        {{--        });--}}
        {{--    }--}}

        {{--    row.remove();--}}
        {{--    console.log(selectedOptions);--}}
        {{--}--}}

        {{--// Call showSelectedOptions for initial rendering--}}
        {{--$(document).ready(function() {--}}
        {{--    showSelectedOptions();--}}
        {{--});--}}
    </script>

@endsection
