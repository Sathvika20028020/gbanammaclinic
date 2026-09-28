@extends('layouts.master')

@section('title', 'Internet Data')
@section('page_title', 'Internet Data')

@section('breadcrumb')
    <li class="breadcrumb-item active">Internet Data</li>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<div class="card">
    <div class="card-body">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"></h4>

    <div class="d-flex gap-2">
        <a href="{{ route('internetdata.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add
        </a>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
    <i class="bi bi-upload me-1"></i> Import
</button>
        <button class="btn btn-secondary" id="exportBtn">
            <i class="bi bi-download me-1"></i> Export
        </button>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-2">
        <label for="corporation_filter" class="form-label">Corporation</label>
        <select class="form-select" id="corporation_filter">
            <option value="">All</option>
            <option value="BBMP">BBMP</option>
        </select>
    </div>
    <div class="col-md-2">
        <label for="constituency_filter" class="form-label">Constituency</label>
        <select class="form-select" id="constituency_filter">
            <option value="">All</option>
            <option value="Bommanahalli">Bommanahalli</option>
            <option value="Jayanagar">Jayanagar</option>
            <option value="Koramangala">Koramangala</option>
            <option value="HSR Layout">HSR Layout</option>
            <option value="BTM Layout">BTM Layout</option>
        </select>
    </div>
    <div class="col-md-2">
        <label for="service_type_filter" class="form-label">Service</label>
        <select class="form-select" id="service_type_filter">
            <option value="">All</option>
            <option value="ACT">ACT</option>
            <option value="Excitel">Excitel</option>
            <option value="Airtel">Airtel</option>
            <option value="Hatway">Hatway</option>
        </select>
    </div>
    <div class="col-md-3">
        <label for="from_date_filter" class="form-label">From Date</label>
        <input type="date" class="form-control" id="from_date_filter">
    </div>
    <div class="col-md-3">
        <label for="to_date_filter" class="form-label">To Date</label>
        <input type="date" class="form-control" id="to_date_filter">
    </div>
</div>

        <div class="table-responsive">
            <table class="display" id="constituencies-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Clinic Name</th>
                        <th>Corportion</th>
                        <th>Constituency</th>
                        <th>Ward</th>
                        <th>Contact Person</th>
                        <th>Contact No</th>
                        <th>Internet Service Provider</th>
                        <th>I.D</th>
                        <th>Last Recharge</th>
                        <th>Expiry Date</th>
                        <th>Plan Validity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                  <tr>
    <td>1</td>
    <td>Gbanamma Clinic</td>
    <td>BBMP</td>
    <td>Bommanahalli</td>
    <td>Ward 189</td>
    <td>Ramesh Kumar</td>
    <td>9876543210</td>
    <td>ACT</td>
    <td>ACT123456</td>
    <td>09-Jul-2026</td>
    <td>08-Aug-2026</td>
    <td>1 Month</td>
    <td><span class="badge bg-success">Active</span></td>
    <td class="text-nowrap">
    <a href="{{ route('internetdata.show') }}" class="btn btn-info btn-sm me-2">
        <i class="fas fa-eye me-1"></i>View
    </a>
    <a href="{{ route('internetdata.edit') }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i>Edit
    </a>
</td>
</tr>

<tr>
    <td>2</td>
    <td>Jayanagar Clinic</td>
    <td>BBMP</td>
    <td>Jayanagar</td>
    <td>Ward 153</td>
    <td>Sunitha</td>
    <td>9123456789</td>
    <td>Excitel</td>
    <td>EXC654321</td>
    <td>05-Jul-2026</td>
    <td>04-Aug-2026</td>
      <td>1 Month</td>
    <td><span class="badge bg-success">Active</span></td>
    <td class="text-nowrap">
    <a href="" class="btn btn-info btn-sm me-2">
        <i class="fas fa-eye me-1"></i>View
    </a>
    <a href="" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i>Edit
    </a>
</td>
</tr>

<tr>
    <td>3</td>
    <td>Koramangala Clinic</td>
    <td>BBMP</td>
    <td>Koramangala</td>
    <td>Ward 151</td>
    <td>Mahesh</td>
    <td>9988776655</td>
    <td>Airtel</td>
    <td>AIR789654</td>
    <td>28-Jun-2026</td>
    <td>28-Jul-2026</td>
      <td>1 Month</td>
    <td><span class="badge bg-warning text-dark">Expiring Soon</span></td>
    <td class="text-nowrap">
    <a href="" class="btn btn-info btn-sm me-2">
        <i class="fas fa-eye me-1"></i>View
    </a>
    <a href="" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i>Edit
    </a>
</td>
</tr>

<tr>
    <td>4</td>
    <td>HSR Layout Clinic</td>
    <td>BBMP</td>
    <td>HSR Layout</td>
    <td>Ward 174</td>
    <td>Priya</td>
    <td>9012345678</td>
    <td>Hatway</td>
    <td>HTW456987</td>
    <td>15-Jun-2026</td>
    <td>15-Jul-2026</td>
        <td>1 Month</td>
    <td><span class="badge bg-danger">Expired</span></td>
    <td class="text-nowrap">
    <a href="" class="btn btn-info btn-sm me-2">
        <i class="fas fa-eye me-1"></i>View
    </a>
    <a href="" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i>Edit
    </a>
</td>
</tr>

<tr>
    <td>5</td>
    <td>BTM Clinic</td>
    <td>BBMP</td>
    <td>BTM Layout</td>
    <td>Ward 147</td>
    <td>Anil</td>
    <td>9090909090</td>
    <td>ACT</td>
    <td>ACT987321</td>
    <td>01-Jul-2026</td>
    <td>31-Jul-2026</td>
      <td>1 Month</td>
    <td><span class="badge bg-success">Active</span></td>
    <td class="text-nowrap">
    <a href="" class="btn btn-info btn-sm me-2">
        <i class="fas fa-eye me-1"></i>View
    </a>
    <a href="" class="btn btn-warning btn-sm">
        <i class="fas fa-edit me-1"></i>Edit
    </a>
</td>
</tr>
                </tbody>

            </table>
        </div>

    </div>
    </div>
    <!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Import Internet Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Choose Excel File</label>
                    <input type="file"
                           id="importFile"
                           class="form-control"
                           accept=".xlsx,.xls,.csv">
                    <small class="text-danger d-none" id="fileError">
                        Please select an Excel or CSV file.
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-success" id="importBtn">
                    Import
                </button>
            </div>

        </div>
    </div>
</div>


@endsection

@push('scripts')


<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#corporation_filter, #constituency_filter, #service_type_filter').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: "Select ",
            allowClear: true
        });

        var table = $('#constituencies-table').DataTable();

        $('#corporation_filter').on('change', function () {
            table.column(2).search(this.value).draw();
        });

        $('#constituency_filter').on('change', function () {
            table.column(3).search(this.value).draw();
        });

        $('#service_type_filter').on('change', function () {
            table.column(7).search(this.value).draw();
        });

        $('#from_date_filter, #to_date_filter').on('change', function () {
            table.draw();
        });
    });

    // Custom Date Range filter for DataTables
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var from = $('#from_date_filter').val();
            var to = $('#to_date_filter').val();
            
            // Assuming "Last Recharge" is at index 9 (10th column)
            var dateStr = data[9]; 
            if (!dateStr) return true;

            var date = new Date(dateStr);
            var fromDate = from ? new Date(from) : null;
            var toDate = to ? new Date(to) : null;
            
            if (fromDate && date < fromDate) return false;
            if (toDate && date > toDate) return false;
            
            return true;
        }
    );
</script>

<script>
    $('#importBtn').click(function () {

        let file = $('#importFile').val();

        if (file == '') {
            $('#fileError').removeClass('d-none');
            return;
        }

        $('#fileError').addClass('d-none');

        // Close Bootstrap Modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
        modal.hide();

        Swal.fire({
            title: 'Importing...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(function () {

            Swal.fire({
                icon: 'success',
                title: 'Imported Successfully!',
                text: 'Internet Data imported successfully.',
                confirmButtonColor: '#198754'
            });

            $('#importFile').val('');

        }, 2000);

    });
</script>


@endpush
