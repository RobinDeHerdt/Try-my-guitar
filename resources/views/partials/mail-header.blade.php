<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        p {
            margin: 10px 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        h1, h2, h3, h4, h5, h6 {
            display: block;
            margin: 0;
            padding: 0;
        }

        img, a img {
            border: 0;
            height: auto;
            outline: none;
            text-decoration: none;
        }

        body, #bodyTable, #bodyCell {
            height: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        #outlook a {
            padding: 0;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        p, a, li, td, blockquote {
            mso-line-height-rule: exactly;
        }

        a[href^=tel], a[href^=sms] {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }

        p, a, li, td, body, table, blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        .ExternalClass, .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font {
            line-height: 100%;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .templateContainer {
            max-width: 600px !important;
        }

        a.mcnButton {
            display: block;
        }

        .mcnImage {
            vertical-align: bottom;
        }

        .mcnTextContent img {
            height: auto !important;
        }

        .mcnDividerBlock {
            table-layout: fixed !important;
        }

        /*
        Page
        Background Style
        Set the background color and top border for your email. You may want to choose colors that match your company's branding.
        */
        body, #bodyTable {
            background-color: #FAFAFA;
        }

        /*
        Page
        Background Style
        Set the background color and top border for your email. You may want to choose colors that match your company's branding.
        */
        #bodyCell {
            border-top: 0;
        }

        /*
        Page
        Heading 1
        Set the styling for all first-level headings in your emails. These should be the largest of your headings.
        heading 1
        */
        h1 {
            color: #202020;
            font-family: Helvetica;
            font-size: 26px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        /*
        Page
        Heading 2
        Set the styling for all second-level headings in your emails.
        heading 2
        */
        h2 {
            color: #202020;
            font-family: Helvetica;
            font-size: 22px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        /*
        Page
        Heading 3
        Set the styling for all third-level headings in your emails.
        heading 3
        */
        h3 {
            color: #202020;
            font-family: Helvetica;
            font-size: 20px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        /*
        Page
        Heading 4
        Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
        heading 4
        */
        h4 {
            color: #202020;
            font-family: Helvetica;
            font-size: 18px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        /*
        Preheader
        Preheader Style
        Set the background color and borders for your email's preheader area.
        */
        #templatePreheader {
            background-color: #FAFAFA;
            background-image: none;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-top: 0;
            border-bottom: 0;
            padding-top: 9px;
            padding-bottom: 9px;
        }

        /*
        Preheader
        Preheader Text
        Set the styling for your email's preheader text. Choose a size and color that is easy to read.
        */
        #templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
            color: #656565;
            font-family: Helvetica;
            font-size: 12px;
            line-height: 150%;
            text-align: left;
        }

        /*
        Preheader
        Preheader Link
        Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
        */
        #templatePreheader .mcnTextContent a, #templatePreheader .mcnTextContent p a {
            color: #656565;
            font-weight: normal;
            text-decoration: underline;
        }

        /*
        Header
        Header Style
        Set the background color and borders for your email's header area.
        */
        #templateHeader {
            background-color: #ffffff;
            background-image: none;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-top: 0;
            border-bottom: 0;
            padding-top: 30px;
            padding-bottom: 0px;
        }

        /*
        Header
        Header Text
        Set the styling for your email's header text. Choose a size and color that is easy to read.
        */
        #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
            color: #202020;
            font-family: Helvetica;
            font-size: 16px;
            line-height: 150%;
            text-align: left;
        }

        /*
        Header
        Header Link
        Set the styling for your email's header links. Choose a color that helps them stand out from your text.
        */
        #templateHeader .mcnTextContent a, #templateHeader .mcnTextContent p a {
            color: #2BAADF;
            font-weight: normal;
            text-decoration: underline;
        }

        /*
        Body
        Body Style
        Set the background color and borders for your email's body area.
        */
        #templateBody {
            background-color: #ffffff;
            background-image: none;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-top: 0;
            border-bottom: 0;
            padding-top: 0px;
            padding-bottom: 50px;
        }

        /*
        Body
        Body Text
        Set the styling for your email's body text. Choose a size and color that is easy to read.
        */
        #templateBody .mcnTextContent, #templateBody .mcnTextContent p {
            color: #202020;
            font-family: Helvetica;
            font-size: 16px;
            line-height: 150%;
            text-align: left;
        }

        /*
        Body
        Body Link
        Set the styling for your email's body links. Choose a color that helps them stand out from your text.
        */
        #templateBody .mcnTextContent a, #templateBody .mcnTextContent p a {
            color: #2BAADF;
            font-weight: normal;
            text-decoration: underline;
        }

        /*
        Footer
        Footer Style
        Set the background color and borders for your email's footer area.
        */
        #templateFooter {
            background-color: #fafafa;
            background-image: none;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            border-top: 0;
            border-bottom: 0;
            padding-top: 0px;
            padding-bottom: 9px;
        }

        /*
        Footer
        Footer Text
        Set the styling for your email's footer text. Choose a size and color that is easy to read.
        */
        #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
            color: #656565;
            font-family: Helvetica;
            font-size: 12px;
            line-height: 150%;
            text-align: center;
        }

        /*
        Footer
        Footer Link
        Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
        */
        #templateFooter .mcnTextContent a, #templateFooter .mcnTextContent p a {
            color: #656565;
            font-weight: normal;
            text-decoration: underline;
        }

        @media only screen and (min-width: 768px) {
            .templateContainer {
                width: 600px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body, table, td, p, a, li, blockquote {
                -webkit-text-size-adjust: none !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            #bodyCell {
                padding-top: 10px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImage {
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCartContainer, .mcnCaptionTopContent, .mcnRecContentContainer, .mcnCaptionBottomContent, .mcnTextContentContainer, .mcnBoxedTextContentContainer, .mcnImageGroupContentContainer, .mcnCaptionLeftTextContentContainer, .mcnCaptionRightTextContentContainer, .mcnCaptionLeftImageContentContainer, .mcnCaptionRightImageContentContainer, .mcnImageCardLeftTextContentContainer, .mcnImageCardRightTextContentContainer {
                max-width: 100% !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnBoxedTextContentContainer {
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupContent {
                padding: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCaptionLeftContentOuter .mcnTextContent, .mcnCaptionRightContentOuter .mcnTextContent {
                padding-top: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardTopImageContent, .mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent {
                padding-top: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardBottomImageContent {
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockInner {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockOuter {
                padding-top: 9px !important;
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnTextContent, .mcnBoxedTextContentColumn {
                padding-right: 18px !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardLeftImageContent, .mcnImageCardRightImageContent {
                padding-right: 18px !important;
                padding-bottom: 0 !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcpreview-image-uploader {
                display: none !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Heading 1
            Make the first-level headings larger in size for better readability on small screens.
            */
            h1 {
                font-size: 22px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Heading 2
            Make the second-level headings larger in size for better readability on small screens.
            */
            h2 {
                font-size: 20px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Heading 3
            Make the third-level headings larger in size for better readability on small screens.
            */
            h3 {
                font-size: 18px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Heading 4
            Make the fourth-level headings larger in size for better readability on small screens.
            */
            h4 {
                font-size: 16px !important;
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Boxed Text
            Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            .mcnBoxedTextContentContainer .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {
                font-size: 14px !important;
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Preheader Visibility
            Set the visibility of the email's preheader on small screens. You can hide it to save space.
            */
            #templatePreheader {
                display: block !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Preheader Text
            Make the preheader text larger in size for better readability on small screens.
            */
            #templatePreheader .mcnTextContent, #templatePreheader .mcnTextContent p {
                font-size: 14px !important;
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Header Text
            Make the header text larger in size for better readability on small screens.
            */
            #templateHeader .mcnTextContent, #templateHeader .mcnTextContent p {
                font-size: 16px !important;
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Body Text
            Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            #templateBody .mcnTextContent, #templateBody .mcnTextContent p {
                font-size: 16px !important;
                line-height: 150% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            /*
            Mobile Styles
            Footer Text
            Make the footer content text larger in size for better readability on small screens.
            */
            #templateFooter .mcnTextContent, #templateFooter .mcnTextContent p {
                font-size: 14px !important;
                line-height: 150% !important;
            }

        }
    </style>
</head>