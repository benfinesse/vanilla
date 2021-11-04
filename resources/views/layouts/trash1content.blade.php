@if(!empty($record->prevOffice))
    <!-- the onclick function is not deleting the item but calling the link with custom warning first -->
    <a href="javascript:void(0)" onclick="deleteItem('{{ route('record.process.next_office', ['record_id'=>$record->uuid,'dir'=>'prev','coffice'=>$record->office->uuid]) }}', 'Are you sure you want to submit to previous office? type yes to proceed.')" class="btn btn-dark mr-2 mb-3">
        <i class="ni ni-back-arrow-fill mr-3"></i> Return to {{ $record->prevOffice->name }}
    </a>
@endif