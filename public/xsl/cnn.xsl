<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
    <html>
        <head>
            <title>RSS Feed with XSLT</title>
            <link rel="stylesheet" type="text/css" href="public/vendor/bootstrap/css/bootstrap.min.css" />
        </head>
        <body>
            <div class="container">  
                <div class="row">   
                    <div class="col-md-8 mx-auto">
                        <a href="index.php">Go back to Scranton Herald</a><br />
                        Would you like to use this XSLT file? <a href="public/xsl/cnn.xsl">Click here.</a>
                        <br /><br />
                        <xsl:apply-templates select="rss/channel/title" />
                        <xsl:apply-templates select="rss/channel/description" />
                        <xsl:apply-templates select="rss/channel/item" />
                    </div>
                </div>          
            </div>
        </body>
    </html>
</xsl:template>

<xsl:template match="item">    
    <div class="card card-outline-secondary my-3">
        <div class="card-header">
            <xsl:apply-templates select="title" />
        </div>
        <div class="card-body">
            <xsl:apply-templates select="pubDate" />
            <xsl:apply-templates select="description" />
            <xsl:apply-templates select="link" />
        </div>
    </div>
</xsl:template>

<xsl:template match="rss/channel/title">
    <h3><xsl:value-of select="."/></h3>
</xsl:template>

<xsl:template match="rss/channel/description">
    <p><xsl:value-of select="."/></p>
</xsl:template>

<xsl:template match="rss/channel/item/title">
    <xsl:value-of select="."/>
</xsl:template>

<xsl:template match="rss/channel/item/description">
    <p class="card-text"><xsl:value-of select="."/></p>
</xsl:template>

<xsl:template match="rss/channel/item/link">
    <a href="{.}" class="btn btn-success">Read more</a>
</xsl:template>

<xsl:template match="rss/channel/item/pubDate">
    <p class="text-muted"><xsl:value-of select="."/></p>
</xsl:template>

</xsl:stylesheet>