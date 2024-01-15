<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<title>KREDIT FINANCIAL ACCESS</title>

<div class="card" style="width: 1260px;">
    <div class="card-body">
        <div style="height:40px" align="centre"></div>

            <table class="table table-bordered">
                <tr>
                    <td colspan="1" style="text-align:center;"><b>LEMBAR OPINI ATAS USULAN KREDIT <br/>Corporate Legal and Litigation Division</b></td>
                    <td><img src="{{ url('logo/jtrust.jpg') }}" width="650px"></td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">OPINI BIDANG HUKUM</th>
                    <th colspan="5" style="text-align:center;"></th>
                </tr>

                <tr>
                    <td>{!! $opini->lembar_opini ?? '' !!}</td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Catatan</th>
                </tr>

                <tr>
                    <td>{!! $opini->catatan ?? '' !!}</td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <td colspan="5">Tanggal : {{ date('d', strtotime($opini->tanggal)) }}-{{ bulan(date('m', strtotime($opini->tanggal))) }}-{{ date('Y', strtotime($opini->tanggal))}}</td>
                </tr>

                <tr>
                    <td colspan="5">No Legal Opini : <input type="text" name="no_legal_opini" class="form-control" value="{{ $opini->no_legal_opini ?? '' }}" readonly></td>
                </tr>

                <tr>
                    <td colspan="5">Dibuat oleh</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Menyetujui <div style="height:30px"></div></td>
                </tr>

                <tr>
                    <td colspan="2">{{ App\User::username($opini->section_head)->name ?? '' }}</td>
                    <td colspan="3">{{ App\User::username($opini->division_head)->name ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Section Head </td>
                    <td colspan="3">Division Head</td>
                </tr>

            </table>

        </form>
    </div>
</div>

<script>
    window.print();
</script>
