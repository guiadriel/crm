<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractFile;
use App\Models\ContractModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ContractsPDFController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Contract $contract)
    {
        if( !$contract ){
            request()->session()->flash('error', 'Contrato não encontrado, por favor tente novamente ou entre em contato com o administrador do sistema.');

            return redirect()->back();
        }

        $models = ContractModel::all();

        $contractFileExists = ContractFile::where('contract_id', '=', $contract->id)->first();


        return view('admin.contracts.pdf.generate', [
            'models' => $models,
            'contract' => $contract,
            'responsible' => $contract->student->responsible ?? null,
            'contractfile' => $contractFileExists
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function renderPDF(Request $request, Contract $contract)
    {
        $preview = $request->action == "PREVIEW" ? true : false;
        if( !$contract ){
            request()->session()->flash('error', 'Contrato não encontrado, por favor tente novamente ou entre em contato com o administrador do sistema.');

            return redirect()->back();
        }

        $pdfAsHtml = view('admin.contracts.pdf.render', [
            'contract' => $contract,
            'description' => $request->description,
            'preview' => $preview
        ])->render();

        if( !$preview ){

            $contractFileExists = ContractFile::where('contract_id', '=', $contract->id)->first();

            if( $contractFileExists ){

                $contractFileExists->content_html = $request->description;
                $contractFileExists->content_pdf = $request->description;

                if( $contractFileExists->save()) {
                    request()->session()->flash('success', "Contrato [{$contract->number}] atualizado com sucesso!");
                }
                return $this->handleStream($pdfAsHtml);

            }

            $file = ContractFile::create([
                'contract_id' => $contract->id,
                'content_html' => $request->description,
                'content_pdf' => $pdfAsHtml
            ]);

            if ( $file ){
                request()->session()->flash('success', "Contrato [{$contract->number}] criado com sucesso!");
            }
        }

        return $this->handleStream($pdfAsHtml);
    }

    public function handleStream($html) {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}
