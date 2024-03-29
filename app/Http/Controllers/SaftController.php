<?php

namespace App\Http\Controllers;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use View;
use File;
use Response;

class SaftController extends Controller
{
    public function get(Request $request)
    {
        $fields = $request->validate([
            'start_date' => 'required|string',
            'end_date' => 'required|string',
        ]);

        $saft_data = $this->getSaftData($fields);

        if (empty($saft_data)) {
            exit();
        }

        $fileName = time() . 'saft.xsd';
        header('Content-Type: application/txt');
        header(
            'Content-Disposition: attachment; filename="' . $fileName . '";'
        );

        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xef) . chr(0xbb) . chr(0xbf));
        $content = preg_replace('/\t/', '', $this->getSaftString());
        fwrite($file, $content);

        exit();
    }

    public function getSaftData($initialData = [])
    {
        $sales_data = Venda::where(function ($query) use ($initialData) {
            $query
                ->whereDate('ven_data_venda', '>=', $initialData['start_date'])
                ->whereDate('ven_data_venda', '<=', $initialData['end_date']);
        })
            ->orderBy('ven_data_venda', 'asc')
            ->get();

        return ['sales' => $sales_data];
    }

    private function getSaftString()
    {
        return '
<?xml version="1.0" encoding="utf-8" ?>
<xs:schema xmlns:doc="urn:schemas-basda-org:schema-extensions:documentation" xmlns:ns="urn:OECD:StandardAuditFile-Tax:AO_1.01_01" xmlns="urn:OECD:StandardAuditFile-Tax:AO_1.01_01" attributeFormDefault="unqualified" elementFormDefault="qualified" targetNamespace="urn:OECD:StandardAuditFile-Tax:AO_1.01_01" version="1.01_01" id="SAF-T_AO" xmlns:xs="http://www.w3.org/2001/XMLSchema">
<xs:annotation>
    <xs:documentation>
    <doc:Title>Standard Audit File - Angola</doc:Title>
    <doc:Subject>Standard Audit File - Angola</doc:Subject>
    <doc:Copyright>Copyright OECD</doc:Copyright>
    <doc:Version>
        <doc:Number>1.01_01</doc:Number>
        <doc:Status>Developement</doc:Status>
    </doc:Version>
    <doc:Author>AGT - Administração Geral Tributária</doc:Author>
    <!-- Contributos para o Projeto -->
    <doc:Contributors>
        <doc:Contributor name="ASSOFT - Associação Portuguesa de Software" url="https://www.assoft.org/" />
        <doc:Contributor name="Nelson Lopes" url="https://github.com/cryptolopes/" />
    </doc:Contributors>
    <doc:ModificationDate>2017-07-16</doc:ModificationDate>
    </xs:documentation>
</xs:annotation>
<!-- Estrutura do ficheiro SAFT-AO-->
<xs:element name="AuditFile">
    <xs:complexType>
    <xs:sequence>
        <xs:element minOccurs="1" ref="Header" />
        <xs:element name="MasterFiles">
        <xs:complexType>
            <xs:sequence>
            <xs:element minOccurs="0" maxOccurs="unbounded" ref="GeneralLedgerAccounts" />
            <xs:element minOccurs="0" maxOccurs="unbounded" ref="Customer" />
            <xs:element minOccurs="0" maxOccurs="unbounded" ref="Supplier" />
            <xs:element minOccurs="0" maxOccurs="unbounded" ref="Product" />
            <xs:element minOccurs="0" ref="TaxTable" />
            </xs:sequence>
        </xs:complexType>
        </xs:element>
        <xs:element minOccurs="0" ref="GeneralLedgerEntries" />
        <xs:element minOccurs="0" ref="SourceDocuments" />
    </xs:sequence>
    </xs:complexType>
    <!-- Constraint-->
    <xs:unique name="AccountIDConstraint">
    <xs:selector xpath="ns:MasterFiles/ns:GeneralLedgerAccounts" />
    <xs:field xpath="ns:AccountID" />
    </xs:unique>
    <xs:unique name="CustomerIDConstraint">
    <xs:selector xpath="ns:MasterFiles/ns:Customer" />
    <xs:field xpath="ns:CustomerID" />
    </xs:unique>
    <xs:unique name="SupplierIDConstraint">
    <xs:selector xpath="ns:MasterFiles/ns:Supplier" />
    <xs:field xpath="ns:SupplierID" />
    </xs:unique>
    <xs:unique name="ProductCodeConstraint">
    <xs:selector xpath="ns:MasterFiles/ns:Product" />
    <xs:field xpath="ns:ProductCode" />
    </xs:unique>
    <xs:keyref name="GeneralLedgerEntriesAccountIDConstraint" refer="AccountIDConstraint">
    <xs:selector xpath="ns:GeneralLedgerEntries/ns:Journal/ns:Transaction/ns:Line" />
    <xs:field xpath="ns:AccountID" />
    </xs:keyref>
    <xs:keyref name="GeneralLedgerEntriesCustomerIDConstraint" refer="CustomerIDConstraint">
    <xs:selector xpath="ns:GeneralLedgerEntries/ns:Journal/ns:Transaction" />
    <xs:field xpath="ns:CustomerID" />
    </xs:keyref>
    <xs:unique name="GeneralLedgerEntriesJournalIdConstraint">
    <xs:selector xpath="ns:GeneralLedgerEntries/ns:Journal" />
    <xs:field xpath="ns:JournalID" />
    </xs:unique>
    <xs:keyref name="GeneralLedgerEntriesSupplierIDConstraint" refer="SupplierIDConstraint">
    <xs:selector xpath="ns:GeneralLedgerEntries/ns:Journal/ns:Transaction" />
    <xs:field xpath="ns:SupplierID" />
    </xs:keyref>
    <xs:unique name="GeneralLedgerEntriesTransactionIdConstraint">
    <xs:selector xpath="ns:GeneralLedgerEntries/ns:Journal/ns:Transaction" />
    <xs:field xpath="ns:TransactionID" />
    </xs:unique>
    <xs:unique name="InvoiceNoConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:SalesInvoices/ns:Invoice" />
    <xs:field xpath="ns:InvoiceNo" />
    </xs:unique>
    <xs:keyref name="InvoiceCustomerIDConstraint" refer="CustomerIDConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:SalesInvoices/ns:Invoice" />
    <xs:field xpath="ns:CustomerID" />
    </xs:keyref>
    <xs:keyref name="InvoiceProductCodeConstraint" refer="ProductCodeConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:SalesInvoices/ns:Invoice/ns:Line" />
    <xs:field xpath="ns:ProductCode" />
    </xs:keyref>
    <xs:unique name="DocumentNumberConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:MovementOfGoods/ns:StockMovement" />
    <xs:field xpath="ns:DocumentNumber" />
    </xs:unique>
    <xs:keyref name="StockMovementCustomerIDConstraint" refer="CustomerIDConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:MovementOfGoods/ns:StockMovement" />
    <xs:field xpath="ns:CustomerID" />
    </xs:keyref>
    <xs:keyref name="StockMovementSupplierIDConstraint" refer="SupplierIDConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:MovementOfGoods/ns:StockMovement" />
    <xs:field xpath="ns:SupplierID" />
    </xs:keyref>
    <xs:keyref name="StockMovementProductCodeConstraint" refer="ProductCodeConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:MovementOfGoods/ns:StockMovement/ns:Line" />
    <xs:field xpath="ns:ProductCode" />
    </xs:keyref>
    <xs:unique name="WorkDocumentDocumentNumberConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:WorkingDocuments/ns:WorkDocument" />
    <xs:field xpath="ns:DocumentNumber" />
    </xs:unique>
    <xs:keyref name="WorkDocumentDocumentCustomerIDConstraint" refer="CustomerIDConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:WorkingDocuments/ns:WorkDocument" />
    <xs:field xpath="ns:CustomerID" />
    </xs:keyref>
    <xs:keyref name="WorkDocumentDocumentProductCodeConstraint" refer="ProductCodeConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:WorkingDocuments/ns:WorkDocument/ns:Line" />
    <xs:field xpath="ns:ProductCode" />
    </xs:keyref>
    <xs:unique name="PaymentPaymentRefNoConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:Payments/ns:Payment" />
    <xs:field xpath="ns:PaymentRefNo" />
    </xs:unique>
    <xs:keyref name="PaymentPaymentRefNoCustomerIDConstraint" refer="CustomerIDConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:Payments/ns:Payment" />
    <xs:field xpath="ns:CustomerID" />
    </xs:keyref>
<!-- Constraints de Documentos Comerciais de Fornecedores -->
    <xs:unique name="InvoicesNoConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:PurchaseInvoices/ns:Invoices" />
    <xs:field xpath="ns:InvoiceNo" />
    </xs:unique>
    <xs:keyref name="InvoiceSupplierIDConstraint" refer="SupplierIDConstraint">
    <xs:selector xpath="ns:SourceDocuments/ns:PurchaseInvoices/ns:Invoices" />
    <xs:field xpath="ns:SupplierID" />
    </xs:keyref>
</xs:element>
<!-- Estrutura de cabecalho (AuditFile.Header) -->
<xs:element name="Header">
    <xs:complexType>
    <xs:sequence>
        <xs:element ref="AuditFileVersion" />
        <xs:element ref="CompanyID" />
        <xs:element name="TaxRegistrationNumber" type="SAFAOAngolaVatNumber" />
        <xs:element ref="TaxAccountingBasis" />
        <xs:element ref="CompanyName" />
        <xs:element minOccurs="0" ref="BusinessName" />
        <xs:element ref="CompanyAddress" />
        <xs:element ref="FiscalYear" />
        <xs:element ref="StartDate" />
        <xs:element ref="EndDate" />
        <xs:element name="CurrencyCode" minOccurs="1" maxOccurs="1">
        <xs:simpleType>
            <xs:restriction base="xs:string">
            <xs:enumeration value="AOA" />
            <xs:enumeration value="USD" />
            </xs:restriction>
        </xs:simpleType>
        </xs:element>
        <xs:element ref="DateCreated" />
        <xs:element ref="TaxEntity" />
        <xs:element ref="ProductCompanyTaxID" />
        <xs:element ref="SoftwareValidationNumber" />
        <xs:element ref="ProductID" />
        <xs:element ref="ProductVersion" />
        <xs:element minOccurs="0" ref="HeaderComment" />
        <xs:element minOccurs="0" ref="Telephone" />
        <xs:element minOccurs="0" ref="Fax" />
        <xs:element minOccurs="0" ref="Email" />
        <xs:element minOccurs="0" ref="Website" />
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!-- Ficheiros Mestre (AuditFile.MasterFiles) -->
<!--    Estrutura do Plano de Contas (AuditFile.MasterFiles.GeneralLedger)-->
<xs:element name="GeneralLedgerAccounts">
    <xs:complexType>
    <xs:sequence>
        <xs:element name="Account" maxOccurs="unbounded">
        <xs:complexType>
            <xs:sequence>
            <xs:element name="AccountID" type="SAFAOGLAccountID" />
            <xs:element ref="AccountDescription" />
            <xs:element ref="OpeningDebitBalance" />
            <xs:element ref="OpeningCreditBalance" />
            <xs:element ref="ClosingDebitBalance" />
            <xs:element ref="ClosingCreditBalance" />
            <xs:element ref="GroupingCategory" />
            <xs:element minOccurs="0" name="GroupingCode" type="SAFAOGLAccountID" />
            </xs:sequence>
        </xs:complexType>
        </xs:element>
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!--    Estrutura de Cliente (AuditFile.MasterFiles.Customer) -->
<xs:element name="Customer">
    <xs:complexType>
    <xs:sequence>
        <xs:element ref="CustomerID" />
        <xs:element ref="AccountID" />
        <xs:element ref="CustomerTaxID" />
        <xs:element ref="CompanyName" />
        <xs:element minOccurs="0" ref="Contact" />
        <xs:element ref="BillingAddress" />
        <xs:element minOccurs="0" maxOccurs="unbounded" ref="ShipToAddress" />
        <xs:element minOccurs="0" ref="Telephone" />
        <xs:element minOccurs="0" ref="Fax" />
        <xs:element minOccurs="0" ref="Email" />
        <xs:element minOccurs="0" ref="Website" />
        <xs:element ref="SelfBillingIndicator" />
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!--    Estrutura de Fornecedor (AuditFile.MasterFiles.Supplier) -->
<xs:element name="Supplier">
    <xs:complexType>
    <xs:sequence>
        <xs:element ref="SupplierID" />
        <xs:element ref="AccountID" />
        <xs:element ref="SupplierTaxID" />
        <xs:element ref="CompanyName" />
        <xs:element minOccurs="0" ref="Contact" />
        <xs:element name="BillingAddress" type="SupplierAddressStructure" />
        <xs:element minOccurs="0" maxOccurs="unbounded" name="ShipFromAddress" type="SupplierAddressStructure" />
        <xs:element minOccurs="0" ref="Telephone" />
        <xs:element minOccurs="0" ref="Fax" />
        <xs:element minOccurs="0" ref="Email" />
        <xs:element minOccurs="0" ref="Website" />
        <xs:element ref="SelfBillingIndicator" />
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!--    Estrutura de produto (AuditFile.MasterFiles.Product)-->
<xs:element name="Product">
    <xs:complexType>
    <xs:sequence>
        <xs:element ref="ProductType" />
        <xs:element ref="ProductCode" />
        <xs:element minOccurs="0" ref="ProductGroup" />
        <xs:element ref="ProductDescription" />
        <xs:element ref="ProductNumberCode" />
        <xs:element name="CustomsDetails" type="CustomsDetails" minOccurs="0" />
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!--    Estrutura de Impostos (AuditFile.MasterFiles.TaxTable) -->
<xs:element name="TaxTable">
    <xs:complexType>
    <xs:sequence>
        <xs:element minOccurs="1" maxOccurs="unbounded" ref="TaxTableEntry" />
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!--    Estrutura de Imposto -->
<xs:element name="TaxTableEntry">
    <xs:complexType>
    <xs:sequence>
        <xs:element ref="TaxType" />
        <xs:element ref="TaxCountryRegion" minOccurs="0" />
        <xs:element name="TaxCode" type="TaxTableEntryTaxCode" />
        <xs:element name="Description" type="SAFAOtextTypeMandatoryMax255Car" />
        <xs:element minOccurs="0" ref="TaxExpirationDate" />
        <xs:choice>
        <xs:element ref="TaxPercentage" />
        <xs:element ref="TaxAmount" />
        </xs:choice>
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!-- Estrutura de Movimentos Contabilisticos (AuditFile.GeneralLedgerEntries)-->
<xs:element name="GeneralLedgerEntries">
    <xs:complexType>
    <xs:sequence>
        <xs:element ref="NumberOfEntries" />
        <xs:element ref="TotalDebit" />
        <xs:element ref="TotalCredit" />
        <xs:element minOccurs="0" maxOccurs="unbounded" name="Journal">
        <xs:complexType>
            <xs:sequence>
            <xs:element ref="JournalID" />
            <xs:element ref="Description" />
            <xs:element minOccurs="0" maxOccurs="unbounded" name="Transaction">
                <xs:complexType>
                <xs:sequence>
                    <xs:element ref="TransactionID" />
                    <xs:element name="Period" type="SAFAOAccountingPeriod" />
                    <xs:element ref="TransactionDate" />
                    <xs:element ref="SourceID" />
                    <xs:element ref="Description" />
                    <xs:element ref="DocArchivalNumber" />
                    <xs:element ref="TransactionType" />
                    <xs:element ref="GLPostingDate" />
                    <xs:choice>
                    <xs:element minOccurs="0" ref="CustomerID" />
                    <xs:element minOccurs="0" ref="SupplierID" />
                    </xs:choice>
                    <xs:element name="Lines">
                    <xs:complexType>
                        <xs:annotation>
                        <xs:documentation>
                            Tem de ser tida em consideração a ordem dos elementos:
                            * Primeiro os de DebitLine
                            * Depois os de CreditLine
                        </xs:documentation>
                        </xs:annotation>
                        <xs:sequence>
                        <xs:group ref="DebitLineGroup" minOccurs="1" maxOccurs="unbounded" />
                        <xs:group ref="CreditLineGroup" minOccurs="1" maxOccurs="unbounded" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                </xs:sequence>
                </xs:complexType>
            </xs:element>
            </xs:sequence>
        </xs:complexType>
        </xs:element>
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!-- Estrutura de Documentos Comerciais (AuditFile.SourceDocuments)-->
<xs:element name="SourceDocuments">
    <xs:complexType>
    <xs:sequence>
        <xs:element minOccurs="0" name="SalesInvoices">
        <xs:complexType>
            <xs:sequence>
            <xs:element ref="NumberOfEntries" />
            <xs:element ref="TotalDebit" />
            <xs:element ref="TotalCredit" />
            <xs:element minOccurs="0" maxOccurs="unbounded" name="Invoice">
                <xs:complexType>
                <xs:sequence>
                    <xs:element ref="InvoiceNo" />
                    <!-- Estrutura da situacao atual do documento -->
                    <xs:element name="DocumentStatus">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="InvoiceStatus" />
                        <!-- Na exportacao de dados relativos a exercicios anteriores em que esta informacao seja desconhecida, este campo devera ser preenchido com a data do documento e hora como 00:00:00 -->
                        <xs:element ref="InvoiceStatusDate" />
                        <xs:element minOccurs="0" ref="Reason" />
                        <xs:element ref="SourceID" />
                        <xs:element name="SourceBilling" type="SAFTAOSourceBilling" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element ref="Hash" />
                    <xs:element ref="HashControl" />
                    <xs:element minOccurs="0" ref="Period" />
                    <xs:element ref="InvoiceDate" />
                    <xs:element ref="InvoiceType" />
                    <xs:element name="SpecialRegimes" type="SpecialRegimes" />
                    <xs:element ref="SourceID" />
                    <xs:element minOccurs="0" ref="EACCode" />
                    <xs:element ref="SystemEntryDate" />
                    <xs:element minOccurs="0" ref="TransactionID" />
                    <xs:element ref="CustomerID" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="ShipTo" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="ShipFrom" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="MovementEndTime" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="MovementStartTime" />
                    <xs:element maxOccurs="unbounded" name="Line">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="LineNumber" />
                        <xs:element minOccurs="0" maxOccurs="unbounded" name="OrderReferences" type="OrderReferences" />
                        <xs:element ref="ProductCode" />
                        <xs:element ref="ProductDescription" />
                        <xs:element ref="Quantity" />
                        <xs:element ref="UnitOfMeasure" />
                        <xs:element ref="UnitPrice" />
                        <xs:element ref="TaxBase" minOccurs="0" />
                        <xs:element ref="TaxPointDate" />
                        <xs:element minOccurs="0" maxOccurs="unbounded" name="References" type="References" />
                        <xs:element ref="Description" />
                        <xs:element name="ProductSerialNumber" type="ProductSerialNumber" minOccurs="0" />
                        <xs:choice>
                            <xs:element ref="DebitAmount" />
                            <xs:element ref="CreditAmount" />
                        </xs:choice>
                        <xs:element name="Tax" type="Tax" />
                        <xs:group ref="TaxExemptions" minOccurs="0" />
                        <xs:element minOccurs="0" ref="SettlementAmount" />
                        <xs:element name="CustomsInformation" type="CustomsInformation" minOccurs="0" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element name="DocumentTotals">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="TaxPayable" />
                        <xs:element ref="NetTotal" />
                        <xs:element ref="GrossTotal" />
                        <xs:element minOccurs="0" name="Currency" type="Currency" />
                        <!-- A estrutura Settlement representa acordos ou formas de pagamento futuros. Nao constitui em caso algum o somatorio dos descontos concedidos e reflectidos nas linhas dos documentos e a informacao aqui constante nao influi o montante total do documento (GrossTotal) -->
                        <xs:element minOccurs="0" maxOccurs="unbounded" name="Settlement" type="Settlement" />
                        <xs:element minOccurs="0" maxOccurs="unbounded" name="Payment" type="PaymentMethod" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element minOccurs="0" maxOccurs="unbounded" name="WithholdingTax" type="WithholdingTax" />
                </xs:sequence>
                </xs:complexType>
            </xs:element>
            </xs:sequence>
        </xs:complexType>
        </xs:element>
        <xs:element minOccurs="0" name="MovementOfGoods">
        <xs:complexType>
            <xs:sequence>
            <xs:element ref="NumberOfMovementLines" />
            <xs:element ref="TotalQuantityIssued" />
            <xs:element minOccurs="0" maxOccurs="unbounded" name="StockMovement">
                <xs:complexType>
                <xs:sequence>
                    <xs:element ref="DocumentNumber" />
                    <!-- Estrutura da situacao atual do documento -->
                    <xs:element name="DocumentStatus">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="MovementStatus" />
                        <!-- Na exportacao de dados relativos a exercicios anteriores em que esta informacao seja desconhecida, este campo devera ser preenchido com a data do documento e hora como 00:00:00 -->
                        <xs:element ref="MovementStatusDate" />
                        <xs:element minOccurs="0" ref="Reason" />
                        <xs:element ref="SourceID" />
                        <xs:element name="SourceBilling" type="SAFTAOSourceBilling" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element ref="Hash" />
                    <xs:element ref="HashControl" />
                    <xs:element minOccurs="0" ref="Period" />
                    <xs:element ref="MovementDate" />
                    <xs:element ref="MovementType" />
                    <xs:element ref="SystemEntryDate" />
                    <xs:element minOccurs="0" ref="TransactionID" />
                    <xs:choice>
                    <xs:element ref="CustomerID" />
                    <xs:element ref="SupplierID" />
                    </xs:choice>
                    <xs:element ref="SourceID" />
                    <xs:element minOccurs="0" ref="EACCode" />
                    <xs:element minOccurs="0" ref="MovementComments" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="ShipTo" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="ShipFrom" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="MovementEndTime" />
                    <xs:element maxOccurs="1" ref="MovementStartTime" />
                    <xs:element minOccurs="0" maxOccurs="1" ref="AGTDocCodeID" />
                    <xs:element maxOccurs="unbounded" name="Line">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="LineNumber" />
                        <xs:element minOccurs="0" maxOccurs="unbounded" name="OrderReferences" type="OrderReferences" />
                        <xs:element ref="ProductCode" />
                        <xs:element ref="ProductDescription" />
                        <xs:element ref="Quantity" />
                        <xs:element ref="UnitOfMeasure" />
                        <xs:element ref="UnitPrice" />
                        <xs:element ref="Description" />
                        <xs:choice>
                            <xs:element ref="DebitAmount" />
                            <xs:element ref="CreditAmount" />
                        </xs:choice>
                        <xs:element minOccurs="0" name="Tax" type="MovementTax" />
                        <xs:group minOccurs="0" ref="TaxExemptions" />
                        <xs:element minOccurs="0" ref="SettlementAmount" />
                        <xs:element name="CustomsInformation" type="CustomsInformation" minOccurs="0" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element name="DocumentTotals">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="TaxPayable" />
                        <xs:element ref="NetTotal" />
                        <xs:element ref="GrossTotal" />
                        <xs:element minOccurs="0" name="Currency" type="Currency" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                </xs:sequence>
                </xs:complexType>
            </xs:element>
            </xs:sequence>
        </xs:complexType>
        </xs:element>
        <xs:element minOccurs="0" name="WorkingDocuments">
        <xs:complexType>
            <xs:sequence>
            <xs:element ref="NumberOfEntries" />
            <xs:element ref="TotalDebit" />
            <xs:element ref="TotalCredit" />
            <xs:element minOccurs="0" maxOccurs="unbounded" name="WorkDocument">
                <xs:complexType>
                <xs:sequence>
                    <xs:element ref="DocumentNumber" />
                    <xs:element name="DocumentStatus">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="WorkStatus" />
                        <!-- Na exportacao de dados relativos a exercicios anteriores em que esta informacao seja desconhecida, este campo devera ser preenchido com a data do documento e hora como 00:00:00 -->
                        <xs:element ref="WorkStatusDate" />
                        <xs:element minOccurs="0" ref="Reason" />
                        <xs:element ref="SourceID" />
                        <xs:element name="SourceBilling" type="SAFTAOSourceBilling" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element ref="Hash" />
                    <xs:element ref="HashControl" />
                    <xs:element minOccurs="0" ref="Period" />
                    <xs:element ref="WorkDate" />
                    <xs:element ref="WorkType" />
                    <xs:element ref="SourceID" />
                    <xs:element minOccurs="0" ref="EACCode" />
                    <xs:element ref="SystemEntryDate" />
                    <xs:element ref="CustomerID" />
                    <xs:element maxOccurs="unbounded" name="Line">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="LineNumber" />
                        <xs:element minOccurs="0" maxOccurs="unbounded" name="OrderReferences" type="OrderReferences" />
                        <xs:element ref="ProductCode" />
                        <xs:element ref="ProductDescription" />
                        <xs:element ref="Quantity" />
                        <xs:element ref="UnitOfMeasure" />
                        <xs:element ref="UnitPrice" />
                        <xs:element ref="TaxPointDate" />
                        <xs:element ref="Description" />
                        <xs:choice>
                            <xs:element ref="DebitAmount" />
                            <xs:element ref="CreditAmount" />
                        </xs:choice>
                        <xs:element minOccurs="0" name="Tax" type="Tax" />
                        <xs:group ref="TaxExemptions" minOccurs="0" />
                        <xs:element minOccurs="0" ref="SettlementAmount" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element name="DocumentTotals">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="TaxPayable" />
                        <xs:element ref="NetTotal" />
                        <xs:element ref="GrossTotal" />
                        <xs:element minOccurs="0" name="Currency" type="Currency" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                </xs:sequence>
                </xs:complexType>
            </xs:element>
            </xs:sequence>
        </xs:complexType>
        </xs:element>
        <xs:element minOccurs="0" name="Payments">
        <xs:complexType>
            <xs:sequence>
            <xs:element ref="NumberOfEntries" />
            <xs:element ref="TotalDebit" />
            <xs:element ref="TotalCredit" />
            <xs:element minOccurs="0" maxOccurs="unbounded" name="Payment">
                <xs:complexType>
                <xs:sequence>
                    <xs:element ref="PaymentRefNo" />
                    <xs:element minOccurs="0" ref="Period" />
                    <xs:element minOccurs="0" ref="TransactionID" />
                    <xs:element ref="TransactionDate" />
                    <xs:element name="PaymentType" type="SAFTAOPaymentType" />
                    <xs:element minOccurs="0" ref="Description" />
                    <xs:element minOccurs="0" ref="SystemID" />
                    <xs:element name="DocumentStatus">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="PaymentStatus" />
                        <!-- Na exportacao de dados relativos a exercicios anteriores em que esta informacao seja desconhecida, este campo devera ser preenchido com a data do documento e hora como 00:00:00 -->
                        <xs:element ref="PaymentStatusDate" />
                        <xs:element minOccurs="0" ref="Reason" />
                        <xs:element ref="SourceID" />
                        <xs:element name="SourcePayment" type="SAFTAOSourcePayment" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element minOccurs="0" maxOccurs="unbounded" name="PaymentMethod" type="PaymentMethod" />
                    <xs:element ref="SourceID" />
                    <xs:element ref="SystemEntryDate" />
                    <xs:element ref="CustomerID" />
                    <xs:element maxOccurs="unbounded" name="Line">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="LineNumber" />
                        <xs:element maxOccurs="unbounded" name="SourceDocumentID">
                            <xs:complexType>
                            <xs:sequence>
                                <xs:element ref="OriginatingON" />
                                <xs:element ref="InvoiceDate" />
                                <xs:element minOccurs="0" ref="Description" />
                            </xs:sequence>
                            </xs:complexType>
                        </xs:element>
                        <xs:element minOccurs="0" ref="SettlementAmount" />
                        <xs:choice>
                            <xs:element ref="DebitAmount" />
                            <xs:element ref="CreditAmount" />
                        </xs:choice>
                        <xs:element minOccurs="0" name="Tax" type="PaymentTax" />
                        <xs:group ref="TaxExemptions" minOccurs="0" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element name="DocumentTotals">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="TaxPayable" />
                        <xs:element ref="NetTotal" />
                        <xs:element ref="GrossTotal" />
                        <!-- O conteudo desta estrutura Settlement representa o somatorio dos descontos reflectidos no elemento SettlementAmount das linhas do recibo. Trata-se de um raciocinio diverso da tabela 4.1 SalesInvoices -->
                        <xs:element minOccurs="0" name="Settlement">
                            <xs:complexType>
                            <xs:sequence>
                                <xs:element ref="SettlementAmount" />
                            </xs:sequence>
                            </xs:complexType>
                        </xs:element>
                        <xs:element minOccurs="0" name="Currency" type="Currency" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                    <xs:element minOccurs="0" maxOccurs="unbounded" name="WithholdingTax" type="WithholdingTax" />
                </xs:sequence>
                </xs:complexType>
            </xs:element>
            </xs:sequence>
        </xs:complexType>
        </xs:element>
        <xs:element minOccurs="0" name="PurchaseInvoices">
        <xs:complexType>
            <xs:annotation>
            <xs:documentation>
                Documentos comerciais de Fornecedores
            </xs:documentation>
            </xs:annotation>
            <xs:sequence>
            <xs:element ref="NumberOfEntries" />
            <xs:element minOccurs="0" maxOccurs="unbounded" name="Invoice">
                <xs:complexType>
                <xs:sequence>
                    <xs:element ref="InvoiceNo" />
                    <xs:element minOccurs="0" ref="Period" />
                    <xs:element ref="InvoiceDate" />
                    <xs:element ref="InvoiceType" />
                    <xs:element ref="SourceID" />
                    <xs:element ref="SupplierID" />
                    <xs:element name="DocumentTotals">
                    <xs:complexType>
                        <xs:sequence>
                        <xs:element ref="InputTax"/>
                        <xs:element ref="TaxPayable" />
                        <xs:element ref="NetTotal" />
                        <xs:element ref="GrossTotal" />
                        <xs:group ref="DeductibleTaxes" minOccurs="0" />
                        <xs:element minOccurs="0" name="Currency" type="Currency" />
                        </xs:sequence>
                    </xs:complexType>
                    </xs:element>
                </xs:sequence>
                </xs:complexType>
            </xs:element>
            </xs:sequence>
        </xs:complexType>
        </xs:element>        
    </xs:sequence>
    </xs:complexType>
</xs:element>
<!-- ESTRUTURAS DE SUPORTE -->
<!-- Estrutura de Moradas -->
<xs:complexType name="AddressStructure">
    <xs:sequence>
    <xs:element minOccurs="0" ref="BuildingNumber" />
    <xs:element minOccurs="0" ref="StreetName" />
    <xs:element ref="AddressDetail" />
    <xs:element ref="City" />
    <xs:element ref="PostalCode" minOccurs="0" />
    <xs:element minOccurs="0" ref="Province" />
    <xs:element ref="Country" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Moradas para Angola-->
<xs:complexType name="AddressStructureAO">
    <xs:sequence>
    <xs:element minOccurs="0" ref="BuildingNumber" />
    <xs:element minOccurs="0" ref="StreetName" />
    <xs:element ref="AddressDetail" />
    <xs:element ref="City" />
    <xs:element minOccurs="0" name="PostalCode" type="PostalCodeAO" />
    <xs:element minOccurs="0" ref="Province" />
    <xs:element name="Country" fixed="AO" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de valor monetario -->
<!-- Este elemento apenas deve ser gerado quando a moeda original do documento for diferente de euro -->
<xs:complexType name="Currency">
    <xs:sequence>
    <xs:element ref="CurrencyCode" />
    <xs:element ref="CurrencyAmount" />
    <xs:element minOccurs="0" ref="ExchangeRate" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de caraterizacao aduaneira de produtos-->
<xs:complexType name="CustomsDetails">
    <xs:annotation>
    <xs:documentation>Preencher com o nº ONU para produtos perigosos </xs:documentation>
    </xs:annotation>
    <xs:sequence>
    <xs:element ref="UNNumber" minOccurs="0" maxOccurs="unbounded" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de informacao aduaneira-->
<xs:complexType name="CustomsInformation">
    <xs:sequence>
    <xs:element ref="ARCNo" minOccurs="0" maxOccurs="unbounded" />
    <xs:element ref="IECAmount" minOccurs="0" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de numero de serie do produto-->
<xs:complexType name="ProductSerialNumber">
    <xs:sequence>
    <xs:element ref="SerialNumber" maxOccurs="unbounded" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Taxa de documentos de movimentacao de mercadorias-->
<xs:complexType name="MovementTax">
    <xs:sequence>
    <xs:element name="TaxType" type="SAFTAOMovementTaxType" />
    <xs:element ref="TaxCountryRegion" minOccurs="0" />
    <xs:element name="TaxCode" type="SAFTAOMovementTaxCode" />
    <xs:element ref="TaxPercentage" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Referencias ao documento de origem-->
<xs:complexType name="OrderReferences">
    <xs:sequence>
    <xs:element minOccurs="0" ref="OriginatingON" />
    <xs:element minOccurs="0" ref="OrderDate" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de pagamentos-->
<xs:complexType name="PaymentMethod">
    <xs:sequence>
    <xs:element ref="PaymentMechanism" />
    <xs:element name="PaymentAmount" type="SAFmonetaryType" />
    <xs:element name="PaymentDate" type="SAFdateType" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Taxa dos recibos-->
<xs:complexType name="PaymentTax">
    <xs:sequence>
    <xs:element ref="TaxType" />
    <xs:element ref="TaxCountryRegion" minOccurs="0" />
    <xs:element name="TaxCode" type="PaymentTaxCode" />
    <xs:choice>
        <xs:element ref="TaxPercentage" />
        <xs:element ref="TaxAmount" />
    </xs:choice>
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de referencias a outros documentos em documentos retificativos de faturas-->
<xs:complexType name="References">
    <xs:sequence>
    <xs:element minOccurs="0" ref="Reference" />
    <xs:element minOccurs="0" ref="Reason" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Acordos entre cliente e fornecedor-->
<xs:complexType name="Settlement">
    <xs:sequence>
    <xs:element minOccurs="0" name="SettlementDiscount" type="SAFAOtextTypeMandatoryMax30Car" />
    <xs:element minOccurs="0" name="SettlementAmount" type="SAFmonetaryType" />
    <xs:element minOccurs="0" name="SettlementDate" type="SAFdateType" />
    <xs:element minOccurs="0" name="PaymentTerms" type="SAFAOtextTypeMandatoryMax100Car" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de entregas de produtos -->
<xs:complexType name="ShippingPointStructure">
    <xs:sequence>
    <xs:element minOccurs="0" maxOccurs="unbounded" ref="DeliveryID" />
    <xs:element minOccurs="0" ref="DeliveryDate" />
    <xs:sequence minOccurs="0" maxOccurs="unbounded">
        <xs:element minOccurs="0" ref="WarehouseID" />
        <xs:element minOccurs="0" ref="LocationID" />
    </xs:sequence>
    <xs:element minOccurs="0" ref="Address" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Regimes especiais de faturacao-->
<xs:complexType name="SpecialRegimes">
    <xs:sequence>
    <xs:element ref="SelfBillingIndicator" />
    <xs:element ref="CashVATSchemeIndicator" />
    <xs:element ref="ThirdPartiesBillingIndicator" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Moradas para Fornecedores-->
<xs:complexType name="SupplierAddressStructure">
    <xs:sequence>
    <xs:element minOccurs="0" ref="BuildingNumber" />
    <xs:element minOccurs="0" ref="StreetName" />
    <xs:element ref="AddressDetail" />
    <xs:element ref="City" />
    <xs:element ref="PostalCode" minOccurs="0" />
    <xs:element minOccurs="0" ref="Province" />
    <xs:element name="Country" type="SupplierCountry" />
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Taxa -->
<xs:complexType name="Tax">
    <xs:sequence>
    <xs:element ref="TaxType" />
    <xs:element ref="TaxCountryRegion" minOccurs="0" />
    <xs:element ref="TaxCode" />
    <xs:choice>
        <xs:element ref="TaxPercentage" />
        <xs:element ref="TaxAmount" />
    </xs:choice>
    </xs:sequence>
</xs:complexType>
<!-- Estrutura de Retencao na fonte-->
<xs:complexType name="WithholdingTax">
    <xs:sequence>
    <xs:element minOccurs="0" ref="WithholdingTaxType" />
    <xs:element minOccurs="0" name="WithholdingTaxDescription" type="SAFAOtextTypeMandatoryMax60Car" />
    <xs:element name="WithholdingTaxAmount" type="SAFmonetaryType" />
    </xs:sequence>
</xs:complexType>
<!-- ELEMENTOS SIMPLES -->
<xs:element name="AccountDescription" type="SAFAOtextTypeMandatoryMax100Car" />
<xs:element name="Address" type="AddressStructure" />
<xs:element name="AddressDetail" type="SAFAOtextTypeMandatoryMax250Car" />
<xs:element name="ARCNo" type="SAFAOtextTypeMandatoryMax21Car" />
<xs:element name="AGTDocCodeID" type="SAFAOtextTypeMandatoryMax200Car" />
<xs:element name="BillingAddress" type="AddressStructure" />
<xs:element name="BuildingNumber" type="SAFAOtextTypeMandatoryMax15Car" />
<xs:element name="BusinessName" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="City" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="ClosingCreditBalance" type="SAFmonetaryType" />
<xs:element name="ClosingDebitBalance" type="SAFmonetaryType" />
<xs:element name="CompanyAddress" type="AddressStructureAO" />
<xs:element name="CompanyName" type="SAFAOtextTypeMandatoryMax200Car" />
<xs:element name="Contact" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="CreditAmount" type="SAFmonetaryType" />
<xs:element name="CurrencyAmount" type="SAFmonetaryType" />
<xs:element name="CustomerID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="CustomerTaxID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="DateCreated" type="SAFAODateSpan" />
<xs:element name="DebitAmount" type="SAFmonetaryType" />
<xs:element name="DeductibleTax" type="SAFMonetaryType2DecimalPlaces"/>
<xs:element name="DeductiblePercentage" type="SAFdecimalType"/>
<xs:element name="DeliveryDate" type="SAFdateType" />
<xs:element name="DeliveryID" type="SAFAOtextTypeMandatoryMax255Car" />
<xs:element name="Description" type="SAFAOtextTypeMandatoryMax200Car" />
<xs:element name="DocArchivalNumber" type="SAFTAODocArchivalNumber" />
<xs:element name="Email" type="SAFAOtextTypeMandatoryMax255Car" />
<xs:element name="EndDate" type="SAFAODateSpan" />
<xs:element name="ExchangeRate" type="SAFdecimalType" />
<xs:element name="Fax" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="GLPostingDate" type="SAFdateType" />
<xs:element name="GrossTotal" type="SAFMonetaryType2DecimalPlaces" />
<xs:element name="Hash" type="SAFAOtextTypeMandatoryMax172Car" />
<xs:element name="HashControl" type="SAFAOtextTypeMandatoryMax70Car" />
<xs:element name="HeaderComment" type="SAFAOtextTypeMandatoryMax255Car" />
<xs:element name="IECAmount" type="SAFmonetaryType" />
<xs:element name="InputTax" type="SAFMonetaryType2DecimalPlaces"/>
<xs:element name="InvoiceDate" type="SAFdateType" />
<xs:element name="InvoiceStatusDate" type="SAFdateTimeType" />
<xs:element name="JournalID" type="SAFAOJournalID" />
<xs:element name="LineNumber" type="xs:nonNegativeInteger" />
<xs:element name="LocationID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="MovementComments" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="MovementDate" type="SAFdateType" />
<xs:element name="MovementEndTime" type="SAFdateTimeType" />
<xs:element name="MovementStartTime" type="SAFdateTimeType" />
<xs:element name="MovementStatusDate" type="SAFdateTimeType" />
<xs:element name="NetTotal" type="SAFMonetaryType2DecimalPlaces" />
<xs:element name="NumberOfEntries" type="xs:nonNegativeInteger" />
<xs:element name="NumberOfMovementLines" type="xs:nonNegativeInteger" />
<xs:element name="OpeningCreditBalance" type="SAFmonetaryType" />
<xs:element name="OpeningDebitBalance" type="SAFmonetaryType" />
<xs:element name="OrderDate" type="SAFdateType" />
<xs:element name="OriginatingON" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="PaymentStatusDate" type="SAFdateTimeType" />
<xs:element name="PostalCode" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="ProductCode" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="ProductCompanyTaxID" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="ProductDescription" type="SAFAOtextTypeMandatoryMax200Car" />
<xs:element name="ProductGroup" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="ProductID" type="SAFAOProductID" />
<xs:element name="ProductNumberCode" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="ProductVersion" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="Quantity" type="SAFdecimalType" />
<xs:element name="Reason" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="RecordID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="Reference" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="Region" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="Province" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="SerialNumber" type="SAFAOtextTypeMandatoryMax100Car" />
<xs:element name="SettlementAmount" type="SAFmonetaryType" />
<xs:element name="ShipFrom" type="ShippingPointStructure" />
<xs:element name="ShipFromAddress" type="AddressStructure" />
<xs:element name="ShipTo" type="ShippingPointStructure" />
<xs:element name="ShipToAddress" type="AddressStructure" />
<xs:element name="SoftwareValidationNumber" type="xs:nonNegativeInteger" />
<xs:element name="SourceDocumentID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="SourceID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="StartDate" type="SAFAODateSpan" />
<xs:element name="StreetName" type="SAFAOtextTypeMandatoryMax200Car" />
<xs:element name="SupplierID" type="SAFAOtextTypeMandatoryMax30Car" />
<xs:element name="SupplierTaxID" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="SystemEntryDate" type="SAFdateTimeType" />
<xs:element name="SystemID" type="SAFAOtextTypeMandatoryMax35Car" />
<xs:element name="TaxAmount" type="SAFmonetaryType" />
<xs:element name="TaxBase" type="SAFmonetaryType" />
<xs:element name="TaxEntity" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="TaxExemptionReason" type="SAFAOTaxExemption" />
<xs:element name="TaxExemptionCode" type="SAFAOTaxExemptionCode" />
<xs:element name="TaxExpirationDate" type="SAFdateType" />
<xs:element name="TaxPayable" type="SAFMonetaryType2DecimalPlaces" />
<xs:element name="TaxPercentage" type="SAFdecimalType" />
<xs:element name="TaxPointDate" type="SAFdateType" />
<xs:element name="TaxVerificationDate" type="SAFdateType" />
<xs:element name="Telephone" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="TotalCredit" type="SAFmonetaryType" />
<xs:element name="TotalDebit" type="SAFmonetaryType" />
<xs:element name="TotalQuantityIssued" type="SAFdecimalType" />
<xs:element name="TransactionDate" type="SAFdateType" />
<xs:element name="TransactionID" type="SAFAOTransactionID" />
<xs:element name="UnitOfMeasure" type="SAFAOtextTypeMandatoryMax20Car" />
<xs:element name="UnitPrice" type="SAFmonetaryType" />
<xs:element name="UNNumber" type="SAFAOUNNumber" />
<xs:element name="WarehouseID" type="SAFAOtextTypeMandatoryMax50Car" />
<xs:element name="Website" type="SAFAOtextTypeMandatoryMax60Car" />
<xs:element name="WorkDate" type="SAFdateType" />
<xs:element name="WorkStatusDate" type="SAFdateTimeType" />
<!-- ELEMENTOS SIMPLES COM RESTRICOES ADICIONAIS-->
<!-- Codigo da Conta -->
<xs:element name="AccountID">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="(([0-9a-zA-Z\-/._+*]*)|Desconhecido)" />
        <xs:minLength value="1" />
        <xs:maxLength value="30" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<xs:element name="AuditFileVersion">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="1.01_01" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Indicador de regime de IVA de Caixa -->
<xs:element name="CashVATSchemeIndicator">
    <xs:simpleType>
    <xs:restriction base="xs:integer">
        <xs:minInclusive value="0" />
        <xs:maxInclusive value="1" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Identificacao da entidade a que respeitam os dados constantes no SAF-T-->
<xs:element name="CompanyID">
    <xs:annotation>
    <xs:documentation>Registo comercial.</xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:minLength value="1" />
        <xs:maxLength value="50" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo do pais (ISO 3166 1-alpha-2) -->
<xs:element name="Country">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="AD|AE|AF|AG|AI|AL|AM|AO|AQ|AR|AS|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BQ|BR|BS|BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CW|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|EH|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS|IT|JE|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|SS|ST|SV|SX|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|UM|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XK|YE|YT|ZA|ZM|ZW|Desconhecido|" />
        <xs:minLength value="2" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo da moeda (ISO 4217) -->
<xs:element name="CurrencyCode">
    <!-- Nao consta o AOA por nao existirem situacoes que requeiram este codigo de moeda -->
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="AED|AFN|ALL|AMD|ANG|ARS|AUD|AWG|AZN|BAM|BBD|BDT|BGN|BHD|BIF|BMD|BND|BOB|BOV|BRL|BSD|BTN|BWP|BYR|BZD|CAD|CDF|CHE|CHF|CHW|CLF|CLP|CNY|COP|COU|CRC|CUC|CUP|CVE|CZK|DJF|DKK|DOP|DZD|EGP|ERN|ETB|EUR|FJD|FKP|GBP|GEL|GHS|GIP|GMD|GNF|GTQ|GYD|HKD|HNL|HRK|HTG|HUF|IDR|ILS|INR|IQD|IRR|ISK|JMD|JOD|JPY|KES|KGS|KHR|KMF|KPW|KRW|KWD|KYD|KZT|LAK|LBP|LKR|LRD|LSL|LTL|LVL|LYD|MAD|MDL|MGA|MKD|MMK|MNT|MOP|MRO|MUR|MVR|MWK|MXN|MXV|MYR|MZN|NAD|NGN|NIO|NOK|NPR|NZD|OMR|PAB|PEN|PGK|PHP|PKR|PLN|PYG|QAR|RON|RSD|RUB|RWF|SAR|SBD|SCR|SDG|SEK|SGD|SHP|SLL|SOS|SRD|SSP|STD|SVC|SYP|SZL|THB|TJS|TMT|TND|TOP|TRY|TTD|TWD|TZS|UAH|UGX|USD|USN|USS|UYI|UYU|UZS|VEF|VND|VUV|WST|XAF|XAG|XAU|XBA|XBB|XBC|XBD|XCD|XDR|XFU|XOF|XPD|XPF|XPT|XSU|XUA|YER|ZAR|ZMW|ZWL|EEK|SKK|TMM|ZMK|ZWD|ZWR" />
        <xs:length value="3" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Identificacao unica do documento de movimentacao de mercadorias e de conferencia-->
<xs:element name="DocumentNumber">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="[^ ]+ [^/^ ]+/[0-9]+" />
        <xs:minLength value="1" />
        <xs:maxLength value="60" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo CAE -->
<xs:element name="EACCode">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="(([0-9]*))" />
        <xs:length value="5" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Ano Fiscal -->
<xs:element name="FiscalYear">
    <xs:simpleType>
    <xs:restriction base="xs:integer">
        <xs:minInclusive value="2000" />
        <xs:maxInclusive value="9999" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Categoria da conta -->
<xs:element name="GroupingCategory">
    <xs:annotation>
    <xs:documentation>
        Deve ser indicado o tipo e a categoria da conta: “GR” – Conta de 1.º grau da contabilidade geral;
        “GA” – Conta agregadora ou integradora da contabilidade geral;
        “GM” – Conta de movimento da contabilidade geral;
        “AR” – Conta de 1.º grau da contabilidade analítica;
        “AA” – Conta agregadora ou integradora da contabilidade analítica; e
        “AM” – Conta de movimento da contabilidade analítica. 
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="GA" />
        <xs:enumeration value="GM" />
        <xs:enumeration value="AR" />
        <xs:enumeration value="AA" />
        <xs:enumeration value="AM" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo unico do documento de venda -->
<xs:element name="InvoiceNo">
    <xs:annotation>
    <xs:documentation>

        Recomenda-se a utlização do seguinte formato:

        InvoiceType + ESPAÇO + / + Número Sequencial
        
        Exemplos: 
        InvoiceType: FT
        InvoiceNo: FT S001/1

        InvoiceType: NC
        InvoiceNo: NC S001/1

    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="[^ ]+ [^/^ ]+/[0-9]+" />
        <xs:minLength value="1" />
        <xs:maxLength value="60" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Estado do documento SalesInvoices -->
<xs:element name="InvoiceStatus">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “N” – Normal;
        “S” – Autofacturação;
        “A” – Documento anulado;
        “R” – Documento de resumo doutros documentos criados noutras aplicações e gerado nesta aplicação;
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="N" />
        <xs:enumeration value="S" />
        <xs:enumeration value="A" />
        <xs:enumeration value="R" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipo de documento de venda-->
<xs:element name="InvoiceType">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:

        “FT” – Factura;
        “FR” – Factura/recibo; 
        “VD” – Venda a dinheiro;
        “GF” – Factura genérica;
        “FG” -Factura global
        “AC” – Aviso de cobrança
        “ND” – Nota de débito
        “NC” – Nota de crédito
        “AF” – Factura/recibo (autofacturação)
        “TV” – Talão de venda
        
        Para o sector Segurador quando não deva constar da tabela 4.3. 
        - Documentos de conferência de mercadorias ou de prestação de serviços (WorkingDocuments), pode ainda ser preenchido com:
        “RP” – Prémio ou recibo de prémio; 
        “RE” – Estorno ou recibo de estorno; 
        “CS” – Imputação a co-seguradoras;
        “LD” – Imputação a co-seguradora líder;
        “RA” – Resseguro aceite.
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="FT" />
        <xs:enumeration value="FR" />
        <xs:enumeration value="ND" />
        <xs:enumeration value="GF" />
        <xs:enumeration value="FG" />
        <xs:enumeration value="AC" />
        <xs:enumeration value="NC" />
        <xs:enumeration value="VD" />
        <xs:enumeration value="TV" />
        <xs:enumeration value="TD" />
        <!-- Para o sector segurador-->
        <xs:enumeration value="RP" />
        <xs:enumeration value="RE" />
        <xs:enumeration value="CS" />
        <xs:enumeration value="LD" />
        <xs:enumeration value="RA" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Estado do documento MovementOfGoods -->
<xs:element name="MovementStatus">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com: “N” – Normal;
        “T” – Por conta de terceiros;
        “A” – Documento anulado;
        “F” – Documento facturado, ainda que parcialmente, quando
        para este documento também existe na tabela 4.1. – Documentos comerciais a clientes (SalesInvoices) o correspondente do tipo factura.
        “R” – Documento de resumo doutros documentos criados noutras aplicações e gerado nesta aplicação. 
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="N" />
        <xs:enumeration value="T" />
        <xs:enumeration value="A" />
        <xs:enumeration value="F" />
        <xs:enumeration value="R" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipo de documento de movimentacao de mercadorias-->
<xs:element name="MovementType">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “GR” – Guia de remessa;
        “GT” – Guia de transporte (incluir aqui as guias globais);
        “GA” – Guia de movimentação de activos fixos próprios; “GC” – Guia de consignação;
        “GD” – Guia ou nota de devolução. 
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="GR" />
        <xs:enumeration value="GT" />
        <xs:enumeration value="GA" />
        <xs:enumeration value="GD" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Meio de pagamento-->
<xs:element name="PaymentMechanism">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “CC” – Cartão crédito;
        “CD” – Cartão débito;
        “CH” – Cheque bancário;
        “CI” – Crédito documentário internacional;
        “CO” – Cheque ou cartão oferta;
        “CS” – Compensação de saldos em conta corrente;
        “DE” – Dinheiro electrónico, por exemplo residente em cartões de fidelidade ou de pontos;
        “MB” – Referências de pagamento para Multicaixa; 
        “NU” – Numerário;


        “OU” – Outros meios aqui não assinalados;
        “PR” – Permuta de bens;
        “TB“ – Transferência bancária ou débito directo autorizado; etc. 
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="CC" />
        <xs:enumeration value="CD" />
        <xs:enumeration value="CH" />
        <xs:enumeration value="CI" />
        <xs:enumeration value="CO" />
        <xs:enumeration value="CS" />
        <xs:enumeration value="DE" />
        <xs:enumeration value="MB" />
        <xs:enumeration value="NU" />
        <xs:enumeration value="OU" />
        <xs:enumeration value="PR" />
        <xs:enumeration value="TB" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo unico do documento de venda -->
<xs:element name="PaymentRefNo">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="[^ ]+ [^/^ ]+/[0-9]+" />
        <xs:minLength value="1" />
        <xs:maxLength value="60" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Estado do documento Payments -->
<xs:element name="PaymentStatus">
    <xs:annotation>
    <xs:documentation>N para normal, A para Anulado </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="N" />
        <xs:enumeration value="A" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo de de Imposto de pagamento-->
<xs:simpleType name="PaymentTaxCode">
    <xs:restriction base="xs:string">
    <xs:pattern value="NOR|ISE|OUT|([0-9.])*|NA|NS" />
    <xs:minLength value="1" />
    <xs:maxLength value="10" />
    </xs:restriction>
</xs:simpleType>
<!-- Periodo contabilistico do documento -->
<xs:element name="Period">
    <xs:simpleType>
    <xs:restriction base="xs:integer">
        <xs:minInclusive value="1" />
        <xs:maxInclusive value="12" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipos de produto -->
<xs:element name="ProductType">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “P” – Produtos;
        “S” – Serviços;
        “O” – Outros (Ex: portes debitados, adiantamentos recebidos ou alienação de activos);
        “E” – Impostos Especiais de Consumo – (ex.:IEC);
        “I” – Impostos, taxas e encargos parafiscais – excepto IVA e IS que deverão ser reflectidos na tabela 2.5

        – Tabela de impostos (Tax Table) e Impostos Especiais de
        Consumo, que deverão ser preenchidos com o código “E”.
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="P" />
        <xs:enumeration value="S" />
        <xs:enumeration value="O" />
        <xs:enumeration value="E" />
        <xs:enumeration value="I" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Indicador de Autofaturacao -->
<xs:element name="SelfBillingIndicator">
    <xs:simpleType>
    <xs:restriction base="xs:integer">
        <xs:minInclusive value="0" />
        <xs:maxInclusive value="1" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipo de sistema que exportou o SAFT -->
<xs:element name="TaxAccountingBasis">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com o tipo de programa fornecendo os dados aplicáveis
        (incluindo os documentos de conferência e os recibos emitidos, quando existam):
            "A" -Aquisição de bens e serviços;
            “I” -Contabilidade integrada com a facturação;
            “C” -Contabilidade;
            “F” -Facturação;
            “P” -Facturação parcial;
            "Q  -Aquisição de bens e serviços integrada com a facturação;
            “R” -Recibos;
            “S” -Autofacturação.
            (a) Deve ser indicado este tipo de programa se este emitir só este tipo de documento. 
            Caso contrário, deverá ser utilizado o tipo “C”, “F” 
        </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="A" />
        <xs:enumeration value="C" />
        <xs:enumeration value="F" />
        <xs:enumeration value="I" />
        <xs:enumeration value="P" />
        <xs:enumeration value="Q" />
        <xs:enumeration value="R" />
        <xs:enumeration value="S" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo de de Imposto -->
<xs:element name="TaxCode">
    <xs:annotation>
    <xs:documentation>
            Código da taxa na tabela de impostos.
            No caso do campo 4.4.4.14.6.1. - Código do tipo de imposto (TaxType) = IVA, deve ser preenchido com:
            “NOR” – Taxa normal; “ISE” – Isenta;
            “OUT” – Outros, aplicável para os regimes especiais de IVA.
            No caso do campo 4.4.4.14.6.1.
            Código do tipo de imposto (TaxType) = IS, deve ser preenchido com:
            O código da verba respectiva; “ISE” – Isenta.

            No caso de não aplicabilidade de imposto deve ser preenchido com “NA”.
        </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="NOR|ISE|OUT|([0-9.])*|NS|NA" />
        <xs:minLength value="1" />
        <xs:maxLength value="10" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Pais ou regiao de Imposto -->
<xs:element name="TaxCountryRegion">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:pattern value="AD|AE|AF|AG|AI|AL|AM|AO|AQ|AR|AS|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BQ|BR|BS|BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CW|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|EH|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS|IT|JE|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|SS|ST|SV|SX|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|UM|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XK|YE|YT|ZA|ZM|ZW|PT-AC|PT-MA" />
        <xs:minLength value="2" />
        <xs:maxLength value="5" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipo de Imposto da tabela de impostos-->
<xs:simpleType name="TaxTableEntryTaxCode">
    <xs:restriction base="xs:string">
    <xs:pattern value="NOR|ISE|OUT|([0-9.])*|NS|NA" />
    <xs:minLength value="1" />
    <xs:maxLength value="10" />
    </xs:restriction>
</xs:simpleType>
<!-- Tipo de Imposto -->
<xs:element name="TaxType">
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="IVA" />
        <xs:enumeration value="IS" />
        <xs:enumeration value="NS" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Indicador de faturacao emitida em nome e por conta de terceiros -->
<xs:element name="ThirdPartiesBillingIndicator">
    <xs:simpleType>
    <xs:restriction base="xs:integer">
        <xs:minInclusive value="0" />
        <xs:maxInclusive value="3" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipos de Movimento Contabilistico -->
<xs:element name="TransactionType">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “N” – Normal;
        “R” – Regularizações do período de tributação; 
        “A” – Apuramento de resultados;
        “J” – Movimentos de ajustamento.  
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="N" />
        <xs:enumeration value="R" />
        <xs:enumeration value="A" />
        <xs:enumeration value="J" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Codigo do tipo de imposto retido -->
<xs:element name="WithholdingTaxType">
    <xs:annotation>
    <xs:documentation>
        Neste campo deve ser indicado o tipo de imposto retido, preenchendo-o com:
        “IRT” – Imposto sobre o rendimento de trabalho; “II” – Imposto sobre o industrial; “IS” – Imposto do selo. 
        </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="IRT" />
        <xs:enumeration value="II" />
        <xs:enumeration value="IS" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Estado do documento WorkingDocuments -->
<xs:element name="WorkStatus">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “N” – Normal;
        “A” – Documento anulado;
        “F” – Documento facturado, ainda que parcialmente, quando para este documento também existe na tabela
        4.1.  –  Documentos Comerciais a clientes (SalesInvoices) o correspondente do tipo factura.
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="N" />
        <xs:enumeration value="A" />
        <xs:enumeration value="F" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- Tipo de documento suscetivel de apresentacao ao cliente para conferencia de entrega de mercadorias ou da prestacao de servicos e Fatura de consignacao nos termos do art. 38. do codigo do IVA -->
<xs:element name="WorkType">
    <xs:annotation>
    <xs:documentation>
        Deve ser preenchido com:
        “CM” – Consultas de mesa;
        “CC” – Credito de consignação;
        “GR” – Guia de remessa;
        “NR” – Nota de remessa;
        “FO” – Folhas de obra;
        “NE” – Nota de Encomenda;
        “OU” – Outros;
        “OR” – Orçamentos;
        “PF” – Pró-forma;
        “DC” – Documentos emitidos que sejam susceptíveis de apresentação ao cliente para conferência de mercadorias ou de prestação de serviços. Para o sector Segurador quando para os tipos de documentos a seguir identificados também deva existir na tabela 4.1 - Documentos comerciais a clientes (SalesInvoices) a correspondente factura ou documento rectificativo de factura, ainda pode ser preenchido com:
        “RP” – Prémio ou recibo de prémio;
        “RE” – Estorno ou recibo de estorno;
        “CS” – Imputação a co-seguradoras; “LD” – Imputação a co-seguradora líder; “RA” – Resseguro aceite.
    </xs:documentation>
    </xs:annotation>
    <xs:simpleType>
    <xs:restriction base="xs:string">
        <xs:enumeration value="CM" />
        <xs:enumeration value="CC" />
        <xs:enumeration value="GR" />
        <xs:enumeration value="NR" />
        <xs:enumeration value="FO" />
        <xs:enumeration value="NE" />
        <xs:enumeration value="OU" />
        <xs:enumeration value="OR" />
        <xs:enumeration value="PF" />
        <xs:enumeration value="DC" />
        <xs:enumeration value="RP" />
        <xs:enumeration value="RE" />
        <xs:enumeration value="CS" />
        <xs:enumeration value="LD" />
        <xs:enumeration value="RA" />
    </xs:restriction>
    </xs:simpleType>
</xs:element>
<!-- TIPOS DE DADOS BASE SAFT OCDE-->
<xs:simpleType name="SAFdateTimeType">
    <xs:restriction base="xs:dateTime" />
</xs:simpleType>
<xs:simpleType name="SAFdateType">
    <xs:restriction base="xs:date" />
</xs:simpleType>
<xs:simpleType name="SAFdecimalType">
    <xs:restriction base="xs:decimal">
    <xs:minInclusive value="0.00" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFmonetaryType">
    <xs:restriction base="xs:decimal">
    <xs:minInclusive value="0.00" />
    </xs:restriction>
</xs:simpleType>
<!-- TIPOS DE DADOS BASE SAFT Angola -->
<!-- Codigo Postal de Portugal -->
<xs:simpleType name="PostalCodePT">
    <xs:restriction base="xs:string">
    <!--  
    <xs:pattern value="([0-9]{4}-[0-9]{3})" /> -->
    </xs:restriction>
</xs:simpleType>
<!-- Codigo Postal de Angola -->
<xs:simpleType name="PostalCodeAO">
    <xs:restriction base="xs:string">
    <xs:minLength value="0" />
    <xs:maxLength value="10" />
    </xs:restriction>
</xs:simpleType>
<!-- Campos Monetários com Duas Casas Decimais -->
<xs:simpleType name="SAFMonetaryType2DecimalPlaces">
    <xs:restriction base="xs:decimal">
    <xs:pattern value="\d+(\.\d{2})" />
    <xs:minInclusive value="0.00" />
    </xs:restriction>
</xs:simpleType>
<!-- Periodo do movimento contabilistico -->
<xs:simpleType name="SAFAOAccountingPeriod">
    <xs:restriction base="xs:integer">
    <xs:minInclusive value="1" />
    <xs:maxInclusive value="16" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAODateSpan">
    <xs:restriction base="xs:date">
    <xs:minInclusive value="2000-01-01" />
    <xs:maxInclusive value="9999-12-31" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFTAODocArchivalNumber">
    <xs:restriction base="xs:string">
    <xs:pattern value="[^ ]{1,20}" />
    <xs:minLength value="1" />
    <xs:maxLength value="20" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOGLAccountID">
    <xs:restriction base="xs:string">
    <xs:pattern value="(([0-9a-zA-Z\-/._+*]*))" />
    <xs:minLength value="1" />
    <xs:maxLength value="30" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOJournalID">
    <xs:restriction base="xs:string">
    <xs:pattern value="[^ ]{1,30}" />
    <xs:minLength value="1" />
    <xs:maxLength value="30" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFTAOMovementTaxCode">
    <xs:restriction base="xs:string">
    <xs:pattern value="NOR|ISE|OUT" />
    <xs:minLength value="1" />
    <xs:maxLength value="3" />
    </xs:restriction>
</xs:simpleType>
<!-- Tipo de Imposto da Tabela MovementOfGoods-->
<xs:simpleType name="SAFTAOMovementTaxType">
    <xs:restriction base="xs:string">
    <xs:enumeration value="IVA" />
    <xs:enumeration value="NS" />
    </xs:restriction>
</xs:simpleType>
<!-- Codigo do motivo de isencao de imposto -->
<xs:simpleType name="SAFAOTaxExemptionCode">
    <xs:restriction base="xs:string">
    <xs:pattern value="(M[0-9]{2})+" />
    </xs:restriction>
</xs:simpleType>
<!-- Aplicação dos motivos de isenção de imposto -->
<xs:group name="TaxExemptions">
    <xs:annotation>
    <xs:documentation>
        Quando aplicável, obriga ao preenchimento de ambos os campos.
    </xs:documentation>
    </xs:annotation>
    <xs:sequence>
    <xs:element ref="TaxExemptionReason" />
    <xs:element ref="TaxExemptionCode" />
    </xs:sequence>
</xs:group>
<!-- Estrutura de DebitLine em GeneralLedgerEntries -->
<xs:group name="DebitLineGroup">
    <xs:sequence>
    <xs:element name="DebitLine">
        <xs:complexType>
        <xs:sequence>
            <xs:element ref="RecordID" />
            <xs:element name="AccountID" type="SAFAOGLAccountID" />
            <xs:element ref="SourceDocumentID" minOccurs="0" />
            <xs:element ref="SystemEntryDate" />
            <xs:element ref="Description" />
            <xs:element name="DebitAmount" type="SAFmonetaryType" />
        </xs:sequence>
        </xs:complexType>
    </xs:element>
    </xs:sequence>
</xs:group>
<!-- Estrutura de CreditLine em GeneralLedgerEntries -->
<xs:group name="CreditLineGroup">
    <xs:sequence>
    <xs:element name="CreditLine">
        <xs:complexType>
        <xs:sequence>
            <xs:element ref="RecordID" />
            <xs:element name="AccountID" type="SAFAOGLAccountID" />
            <xs:element ref="SourceDocumentID" minOccurs="0" />
            <xs:element ref="SystemEntryDate" />
            <xs:element ref="Description" />
            <xs:element name="CreditAmount" type="SAFmonetaryType" />
        </xs:sequence>
        </xs:complexType>
    </xs:element>
    </xs:sequence>
</xs:group>
<!-- Estrutura de DeductibleTaxes -->
<xs:group name="DeductibleTaxes">
    <xs:sequence>
    <xs:element ref="DeductibleTax" minOccurs="1"/>
    <xs:element ref="DeductiblePercentage" minOccurs="1" ></xs:element>
    </xs:sequence>
</xs:group>
<xs:simpleType name="SAFTAOPaymentType">
    <xs:annotation>
    <xs:documentation>
        >Deve ser preenchido com:
        “RC” – Recibo emitido
        “AR” – Aviso de cobrança/recibo 
        “RG” – Outros recibos emitidos.
    </xs:documentation>
    </xs:annotation>
    <xs:restriction base="xs:string">
    <xs:enumeration value="RC" />
    <xs:enumeration value="RG" />
    <xs:enumeration value="AR" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOTaxExemption">
    <xs:restriction base="xs:string">
    <xs:minLength value="6" />
    <xs:maxLength value="60" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOAngolaVatNumber">
    <xs:annotation>
    <xs:documentation>Preencher com o NIF Angolano sem espaços e sem qualquer prefixo do país.</xs:documentation>
    </xs:annotation>
    <xs:restriction base="xs:string">
    <xs:pattern value="[A-Z\d]*" />
    <xs:minLength value="10" />
    <xs:maxLength value="15" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOProductID">
    <xs:restriction base="xs:string">
    <xs:pattern value="[^/]+/[^/]+" />
    <xs:minLength value="3" />
    <xs:maxLength value="255" />
    </xs:restriction>
</xs:simpleType>
<!-- Origem do documento -->
<xs:simpleType name="SAFTAOSourceBilling">
    <xs:annotation>
    <xs:documentation>
        P para documento produzido na aplicacao, 
        I para documento integrado e produzido noutra aplicacao, 
        M para documento proveniente de recuperacao ou de emissao manual 
    </xs:documentation>
    </xs:annotation>
    <xs:restriction base="xs:string">
    <xs:enumeration value="P" />
    <xs:enumeration value="I" />
    <xs:enumeration value="M" />
    </xs:restriction>
</xs:simpleType>
<!-- Origem do documento -->
<xs:simpleType name="SAFTAOSourcePayment">
    <xs:annotation>
    <xs:documentation>P para documento produzido na aplicacao, I para documento integrado e produzido noutra aplicacao, M para documento proveniente de recuperacao ou de emissao manual </xs:documentation>
    </xs:annotation>
    <xs:restriction base="xs:string">
    <xs:enumeration value="P" />
    <xs:enumeration value="I" />
    <xs:enumeration value="M" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax3Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="3" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax10Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="10" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax15Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="15" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax20Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="20" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax21Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="20" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax30Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="30" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax35Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="35" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax40Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="40" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax50Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="50" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax60Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="60" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax70Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="70" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax90Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="90" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax100Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="100" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax172Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="172" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax200Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="200" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax250Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="250" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMandatoryMax255Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="1" />
    <xs:maxLength value="255" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOtextTypeMax40Car">
    <xs:restriction base="xs:string">
    <xs:minLength value="0" />
    <xs:maxLength value="40" />
    </xs:restriction>
</xs:simpleType>
<xs:simpleType name="SAFAOTransactionID">
    <xs:annotation>
    <xs:documentation>
        O preenchimento é obrigatório, no caso de se tratar de um sistema integrado de contabilidade e facturação, 
        ainda que o tipo de ficheiro (TaxAccountingBasis) não deva conter as tabelas relativas à contabilidade.
        
        Deve ser indicada a chave única da tabela 3.
        Movimentos contabilísticos (GeneralLedgerEntries) da transacção onde foi lançado este documento, 
        respeitando a regra aí definida para o campo 3.4.3.1 - Chave única do movimento contabilístico (TransactionID).
        </xs:documentation>
    </xs:annotation>
    <xs:restriction base="xs:string">
    <xs:pattern value="[1-9][0-9]{3}-[01][0-9]-[0-3][0-9] [^ ]{1,30} [^ ]{1,20}" />
    <xs:minLength value="1" />
    <xs:maxLength value="70" />
    </xs:restriction>
</xs:simpleType>
<!-- Numero ONU para substancias perigosas -->
<xs:simpleType name="SAFAOUNNumber">
    <xs:restriction base="xs:string">
    <xs:pattern value="[0-9]{4}" />
    <xs:length value="4" />
    </xs:restriction>
</xs:simpleType>
<!-- Codigo do pais (ISO 3166 1-alpha-2) -->
<xs:simpleType name="SupplierCountry">
    <xs:restriction base="xs:string">
    <xs:pattern value="AD|AE|AF|AG|AI|AL|AM|AO|AQ|AR|AS|AT|AU|AW|AX|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BQ|BR|BS|BT|BV|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CW|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|EH|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GF|GG|GH|GI|GL|GM|GN|GP|GQ|GR|GS|GT|GU|GW|GY|HK|HM|HN|HR|HT|HU|ID|IE|IL|IM|IN|IO|IQ|IR|IS|IT|JE|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MQ|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NF|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PS|PT|PW|PY|QA|RE|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SJ|SK|SL|SM|SN|SO|SR|SS|ST|SV|SX|SY|SZ|TC|TD|TF|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|UM|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|XK|YE|YT|ZA|ZM|ZW|" />
    <xs:length value="2" />
    </xs:restriction>
</xs:simpleType>
</xs:schema>
    ';
    }
}
