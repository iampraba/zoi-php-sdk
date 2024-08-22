<?php 
namespace com\zoho\officeintegrator\v1;

use com\zoho\officeintegrator\exception\SDKException;
use com\zoho\officeintegrator\util\CommonAPIHandler;
use com\zoho\officeintegrator\util\Constants;
use com\zoho\officeintegrator\util\APIResponse;

class V1Operations
{

	/**
	 * The method to create document
	 * @param CreateDocumentParameters $request An instance of CreateDocumentParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createDocument(CreateDocumentParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/documents'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create document preview
	 * @param PreviewParameters $request An instance of PreviewParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createDocumentPreview(PreviewParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/preview'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_document_preview'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create watermark document
	 * @param WatermarkParameters $request An instance of WatermarkParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createWatermarkDocument(WatermarkParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/watermark'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_watermark_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create mail merge template
	 * @param MailMergeTemplateParameters $request An instance of MailMergeTemplateParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createMailMergeTemplate(MailMergeTemplateParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/templates'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_mail_merge_template'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get merge fields
	 * @param GetMergeFieldsParameters $request An instance of GetMergeFieldsParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getMergeFields(GetMergeFieldsParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/fields'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('get_merge_fields'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to merge and deliver via webhook
	 * @param MergeAndDeliverViaWebhookParameters $request An instance of MergeAndDeliverViaWebhookParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function mergeAndDeliverViaWebhook(MergeAndDeliverViaWebhookParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/merge/webhook'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('merge_and_deliver_via_webhook'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to merge and download document
	 * @param MergeAndDownloadDocumentParameters $request An instance of MergeAndDownloadDocumentParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function mergeAndDownloadDocument(MergeAndDownloadDocumentParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/merge'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('merge_and_download_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create fillable template document
	 * @param CreateDocumentParameters $request An instance of CreateDocumentParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createFillableTemplateDocument(CreateDocumentParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/fillabletemplates'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_fillable_template_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create fillable link
	 * @param FillableLinkParameters $request An instance of FillableLinkParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createFillableLink(FillableLinkParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/fillabletemplates/fillablelink'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_fillable_link'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to convert document
	 * @param DocumentConversionParameters $request An instance of DocumentConversionParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function convertDocument(DocumentConversionParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/convert'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('convert_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to combine pdfs
	 * @param CombinePDFsParameters $request An instance of CombinePDFsParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function combinePdfs(CombinePDFsParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/combine'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('combine_pdfs'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to compare document
	 * @param CompareDocumentParameters $request An instance of CompareDocumentParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function compareDocument(CompareDocumentParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/document/compare'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('compare_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get all sessions
	 * @param string $documentid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getAllSessions(string $documentid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/documents/'); 
		$apiPath=$apiPath.(strval($documentid)); 
		$apiPath=$apiPath.('/sessions'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_GET); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('get_all_sessions'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get session
	 * @param string $sessionid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getSession(string $sessionid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/sessions/'); 
		$apiPath=$apiPath.(strval($sessionid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_GET); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('get_session'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to delete session
	 * @param string $sessionid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function deleteSession(string $sessionid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/sessions/'); 
		$apiPath=$apiPath.(strval($sessionid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_DELETE); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('delete_session'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get document info
	 * @param string $documentid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getDocumentInfo(string $documentid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/documents/'); 
		$apiPath=$apiPath.(strval($documentid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_GET); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('get_document_info'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to delete document
	 * @param string $documentid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function deleteDocument(string $documentid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/writer/officeapi/v1/documents/'); 
		$apiPath=$apiPath.(strval($documentid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_DELETE); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('delete_document'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create sheet
	 * @param CreateSheetParameters $request An instance of CreateSheetParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createSheet(CreateSheetParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/spreadsheet'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_sheet'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create sheet preview
	 * @param SheetPreviewParameters $request An instance of SheetPreviewParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createSheetPreview(SheetPreviewParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/spreadsheet/preview'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_sheet_preview'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to download sheet
	 * @param string $documentid A string
	 * @param SheetDownloadParameters $request An instance of SheetDownloadParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function downloadSheet(string $documentid, SheetDownloadParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/spreadsheet/'); 
		$apiPath=$apiPath.(strval($documentid)); 
		$apiPath=$apiPath.('/download'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('download_sheet'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to convert sheet
	 * @param SheetConversionParameters $request An instance of SheetConversionParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function convertSheet(SheetConversionParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/spreadsheet/convert'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('convert_sheet'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get sheet session
	 * @param string $sessionid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getSheetSession(string $sessionid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/sessions/'); 
		$apiPath=$apiPath.(strval($sessionid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_GET); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('get_sheet_session'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to delete sheet session
	 * @param string $sessionid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function deleteSheetSession(string $sessionid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/session/'); 
		$apiPath=$apiPath.(strval($sessionid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_DELETE); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('delete_sheet_session'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to delete sheet
	 * @param string $documentid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function deleteSheet(string $documentid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/sheet/officeapi/v1/spreadsheet/'); 
		$apiPath=$apiPath.(strval($documentid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_DELETE); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('delete_sheet'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create presentation
	 * @param CreatePresentationParameters $request An instance of CreatePresentationParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createPresentation(CreatePresentationParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/show/officeapi/v1/presentation'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_presentation'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to convert presentation
	 * @param ConvertPresentationParameters $request An instance of ConvertPresentationParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function convertPresentation(ConvertPresentationParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/show/officeapi/v1/presentation/convert'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('convert_presentation'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to create presentation preview
	 * @param PresentationPreviewParameters $request An instance of PresentationPreviewParameters
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function createPresentationPreview(PresentationPreviewParameters $request)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/show/officeapi/v1/presentation/preview'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_POST); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_CREATE); 
		$handlerInstance->setRequest($request); 
		$handlerInstance->setMethodName('create_presentation_preview'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get presentation session
	 * @param string $sessionid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getPresentationSession(string $sessionid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/show/officeapi/v1/sessions/'); 
		$apiPath=$apiPath.(strval($sessionid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_GET); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('get_presentation_session'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to delete presentation session
	 * @param string $sessionid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function deletePresentationSession(string $sessionid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/show/officeapi/v1/session/'); 
		$apiPath=$apiPath.(strval($sessionid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_DELETE); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('delete_presentation_session'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to delete presentation
	 * @param string $documentid A string
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function deletePresentation(string $documentid)
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/show/officeapi/v1/presentation/'); 
		$apiPath=$apiPath.(strval($documentid)); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_DELETE); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('delete_presentation'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}

	/**
	 * The method to get plan details
	 * @return APIResponse | null An instance of APIResponse
	 */
	public  function getPlanDetails()
	{
		$handlerInstance=new CommonAPIHandler(); 
		$apiPath=""; 
		$apiPath=$apiPath.('/api/v1/plan'); 
		$handlerInstance->setAPIPath($apiPath); 
		$handlerInstance->setHttpMethod(Constants::REQUEST_METHOD_GET); 
		$handlerInstance->setCategoryMethod(Constants::REQUEST_CATEGORY_READ); 
		$handlerInstance->setMethodName('get_plan_details'); 
		$handlerInstance->setOperationClassName('com.zoho.officeintegrator.V1.V1Operations'); 
		return $handlerInstance->apiCall(); 

	}
} 
