<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
    <html>
        <body>
            <xsl:apply-templates select="rss/channel/title" />
            <xsl:apply-templates select="rss/channel/description" />
            <table border="1">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
                <xsl:apply-templates select="rss/channel/item" />
            </table>
        </body>
    </html>
</xsl:template>

<xsl:template match="item">    
        <tr>
            <xsl:apply-templates select="title" />
            <xsl:apply-templates select="description" />
        </tr>
</xsl:template>

<xsl:template match="rss/channel/title">
    <h3><xsl:value-of select="."/></h3>
</xsl:template>

<xsl:template match="rss/channel/description">
    <p><xsl:value-of select="."/></p>
</xsl:template>

<xsl:template match="rss/channel/item/title">
    <td><xsl:value-of select="."/></td>
</xsl:template>

<xsl:template match="rss/channel/item/description">
    <td><xsl:value-of select="."/></td>
</xsl:template>

</xsl:stylesheet>