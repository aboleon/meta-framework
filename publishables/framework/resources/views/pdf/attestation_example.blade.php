<x-pdf-layout>

    @section('meta', 'Attestation PDF')
    @push('css')
        {!!  csscrush_inline(public_path('vendor/aboleon-framework/css/pdf.css')) !!}
    @endpush

    <table>
        <tr>
            <td>
                <img src="{{ asset('media/pdf/logo.png') }}" alt="République française" width="128"/>
            </td>
        </tr>
    </table>
    <br>

    <h5>Groupement d’Intérêt Public de la Formation<br>
        Continue et de l’Insertion Professionnelle<br>
        Académie Aix-Marseille
    </h5>
        <br><br>
    <p style="text-align:right;font-size: 14px">Aix-en-Provence, le {{ date('d/m/Y') }}
    </p>

    <br><br><br>
    <h1>ATTESTATION DE FORMATION</h1>
    <br><br>
    <table>
        <tr>
            <td class="card">
                <p>
                    GIP-FCIP<br>
                    Académie<br>
                    Aix Marseille
                </p>

            </td>
            <td style="padding-left: 30px">
                <p>
                    Je soussignée, Marie-Laure Follot, Directrice du Groupement d’intérêt public, de la formation continue et de l’insertion professionnelle certifie par la présente que...
                </p>
            </td>
        </tr>
    </table>


</x-pdf-layout>
