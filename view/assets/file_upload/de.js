/*!
 * FileInput Turkish Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinputLocales['de'] = {
         fileSingle: 'Datei',
    filePlural: 'Dateien',
    browseLabel: 'Durchsuchen &hellip;',
    removeLabel: 'Löschen',
    removeTitle: 'Ausgewählte Dateien löschen',
    cancelLabel: 'Abbrechen',
    cancelTitle: 'Laufenden Upload abbrechen',
    uploadLabel: 'Hochladen',
    uploadTitle: 'Ausgewählte Dateien hochladen',
    msgNo: 'Nein',
    msgNoFilesSelected: '',
    msgCancelled: 'Abgebrochen',
    msgPlaceholder: 'Wähle {files}',
    msgZoomModalHeading: 'Detaillierte Vorschau',
    msgFileRequired: 'Du musst eine Datei zum Hochladen auswählen.',
    msgSizeTooSmall: 'Die Datei "{name}" (<b>{size} KB</b>) ist zu klein und muss größer als <b>{minSize} KB</b> sein.',
    msgSizeTooLarge: 'Die Datei "{name}" ist zu groß (<b>{size} KB</b>) und darf maximal <b>{maxSize} KB</b> sein.',
    msgFilesTooLess: 'Du musst mindestens <b>{n}</b> {files} zum Hochladen auswählen.',
    msgFilesTooMany: 'Die Anzahl der ausgewählten Dateien <b>({n})</b> darf die maximal erlaubte Anzahl <b>({m})</b> nicht überschreiten.',
    msgFileNotFound: 'Die Datei "{name}" wurde nicht gefunden!',
    msgFileSecured: 'Sicherheitsbeschränkungen verhindern das Lesen der Datei "{name}".',
    msgFileNotReadable: 'Die Datei "{name}" kann nicht gelesen werden.',
    msgFilePreviewAborted: 'Die Vorschau für die Datei "{name}" wurde abgebrochen.',
    msgFilePreviewError: 'Beim Lesen der Datei "{name}" ist ein Fehler aufgetreten.',
    msgInvalidFileName: 'Der Dateiname "{name}" enthält ungültige oder nicht unterstützte Zeichen.',
    msgInvalidFileType: 'Der Dateityp der Datei "{name}" ist ungültig. Es sind nur Dateien des Typs "{types}" erlaubt.',
    msgInvalidFileExtension: 'Die Dateiendung der Datei "{name}" ist ungültig. Nur Dateien mit den Endungen "{extensions}" sind erlaubt.',
    msgFileTypes: {
        'image': 'Bild',
        'html': 'HTML',
        'text': 'Text',
        'video': 'Video',
        'audio': 'Audio',
        'flash': 'Flash',
        'pdf': 'PDF',
        'object': 'Objekt'
    },
    msgUploadAborted: 'Dateiupload abgebrochen',
    msgUploadThreshold: 'Verarbeitung läuft...',
    msgUploadBegin: 'Beginne...',
    msgUploadEnd: 'Erfolgreich',
    msgUploadEmpty: 'Es sind keine gültigen Daten zum Hochladen vorhanden.',
    msgUploadError: 'Fehler',
    msgValidationError: 'Validierungsfehler',
    msgLoading: 'Lade Datei {index} / {files} &hellip;',
    msgProgress: 'Lade Datei {index} / {files} - {name} - %{percent} abgeschlossen.',
    msgSelected: '{n} {files} ausgewählt',
    msgFoldersNotAllowed: 'Du kannst nur Dateien per Drag & Drop hochladen! {n} Ordner wurden ignoriert.',
    msgImageWidthSmall: 'Die Breite des Bildes "{name}" sollte mindestens {size} Pixel betragen.',
    msgImageHeightSmall: 'Die Höhe des Bildes "{name}" sollte mindestens {size} Pixel betragen.',
    msgImageWidthLarge: 'Die Breite des Bildes "{name}" darf {size} Pixel nicht überschreiten.',
    msgImageHeightLarge: 'Die Höhe des Bildes "{name}" darf {size} Pixel nicht überschreiten.',
    msgImageResizeError: 'Bildgröße konnte nicht geändert werden.',
    msgImageResizeException: 'Fehler beim Ändern der Bildgröße.<pre>{errors}</pre>',
    msgAjaxError: 'Etwas ist schiefgelaufen bei der Operation "{operation}". Bitte versuche es später erneut!',
    msgAjaxProgressError: 'Die Operation "{operation}" war nicht erfolgreich.',
    ajaxOperations: {
        deleteThumb: 'Datei löschen',
        uploadThumb: 'Datei hochladen',
        uploadBatch: 'Stapelhochladen von Dateien',
        uploadExtra: 'Formulardaten hochladen'
    },
    dropZoneTitle: 'Dateien hier ablegen',
    dropZoneClickTitle: '<br>(oder klicke, um {files} auszuwählen)',
    fileActionSettings: {
        removeTitle: 'Datei entfernen',
        uploadTitle: 'Datei hochladen',
        uploadRetryTitle: 'Erneut versuchen',
        zoomTitle: 'Details anzeigen',
        dragTitle: 'Verschieben / Neu anordnen',
        indicatorNewTitle: 'Noch nicht hochgeladen',
        indicatorSuccessTitle: 'Hochgeladen',
        indicatorErrorTitle: 'Fehler beim Hochladen',
        indicatorLoadingTitle: 'Wird geladen...'
    },
    previewZoomButtonTitles: {
        prev: 'Vorherige Datei anzeigen',
        next: 'Nächste Datei anzeigen',
        toggleheader: 'Header umschalten',
        fullscreen: 'Vollbild umschalten',
        borderless: 'Rahmenlosen Modus umschalten',
        close: 'Detaillierte Vorschau schließen'
    }
    };
})(window.jQuery);
