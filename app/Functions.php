<?php

namespace App;

class Functions
{
    public static function slugify($text, string $divider = '-')
    {
      // replace non letter or digits by divider
      $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
    
      // trim
      $text = trim($text, $divider);
    
      // remove duplicate divider
      $text = preg_replace('~-+~', $divider, $text);
    
      // lowercase
      $text = strtolower($text);
    
      if (empty($text)) {
        return Functions::makeIdPublic();
      }
    
      return $text;
    }

    public static function makeIdPublic() {
      $idPublic = bin2hex(random_bytes(16));
    
      return $idPublic;
    }

    public static function creationDateLittleEndian($creation_date) {
        $phpdate = strtotime($creation_date);
        $creation_date = date('d/m/Y', $phpdate);
    
        return $creation_date;
    }

    public static function checkErrorUploadFile($file) {
        switch ($file['error']) {
            case 0:
                $message = null;
                break;
            case 1:
                $message = "Le fichier téléchargé dépasse la limite de poids maximal autorisé.";
                break;
            case 2:
                $message = "Le fichier téléchargé dépasse la limite de poids maximal autorisé.";
                break;
            case 3:
                $message = "Le fichier téléchargé n'a été que partiellement téléchargé.";
                break;
            case 4:
                $message = "Aucun fichier n'a été téléchargé.";
                break;
            case 6:
                $message = "Impossible de téléchargé le fichier";
                break;
            case 7:
                $message = "Impossible de téléchargé le fichier";
                break;
            case 8:
                $message = "Impossible de téléchargé le fichier";
                break;
        
            default:
                $message = "Impossible de téléchargé le fichier";
                break;
        }
        return $message;
    }

    public static function checkImageTypeUploadFile($file) {
        switch ($file['type']) {
            case 'image/png':
                $extension = ".png";
                break;
            case 'image/jpeg':
                $extension = ".jpeg";
                break;
            case 'image/bmp':
                $extension = ".bmp";
                break;
            case 'image/gif':
                $extension = ".gif";
                break;
            case 'image/tiff':
                $extension = ".tiff";
                break;
            case 'image/webp':
                $extension = ".webp";
                break;
        
            default:
                $extension = null;
                break;
        }
        return $extension;
    }

    public static function validationInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    public static function validationContentsArticle($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data, '<h1><h2><h3><h4><h5><h6><p><a><img><strong><em><i><u><b><s><ul><ol><li><blockquote><code><pre><hr><br><span><div><iframe>');
        $data = htmlspecialchars($data, ENT_HTML5, 'UTF-8');
        return $data;
    }

    public static function PrintContentsArticle($data) {
        return html_entity_decode($data, ENT_HTML5, 'UTF-8');
    }

    public static function printDescription($data) {
        $data = strip_tags($data);
        $data = substr($data, 0, 150);
        $data = $data . '...';
      
        return $data;
    }
}