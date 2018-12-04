<?xml version="1.0" encoding="UTF-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<body>
    <h2><xsl:value-of select="rss/channel/title"/></h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Description</th>
        </tr>
        <xsl:for-each select="rss/channel/item">
        <tr>
            <td><xsl:value-of select="title"/></td>
            <td><xsl:value-of select="pubDate"/></td>
            <td><xsl:value-of select="description"/></td>
        </tr>
        </xsl:for-each>
    </table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>