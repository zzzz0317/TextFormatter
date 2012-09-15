
	/**
	* @testdox Not safe: <embed src="{@url}"/>
	*/
	public function testChe
	/**
	* @testdox Not safe: <embed src="{@url}"/>
	*/
	public function testCheckUnsafeFFEA6CBF()
	{
		$this->testCheckUnsafe(
			'<embed src="{@url}"/>',
			"The template contains a 'embed' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <iframe src="{@url}"/>
	*/
	public function testCheckUnsafeA56D0DBC()
	{
		$this->testCheckUnsafe(
			'<iframe src="{@url}"/>',
			"The template contains a 'iframe' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <object data="{@url}"/>
	*/
	public function testCheckUnsafe200651EB()
	{
		$this->testCheckUnsafe(
			'<object data="{@url}"/>',
			"The template contains a 'object' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script src="{@url}"/>
	*/
	public function testCheckUnsafeFDDAD6DB()
	{
		$this->testCheckUnsafe(
			'<script src="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe if attribute 'id' has filter '#url': <script src="{@url}"/>
	*/
	public function testCheckUnsafeD10CCD19()
	{
		$this->testCheckUnsafe(
			'<script src="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL",
			array('attributes' => array('id' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'id' has filter '#number': <script src="https://gist.github.com/{@id}.js"/>
	*/
	public function testCheckUnsafe6C30CE54()
	{
		$this->testCheckUnsafe(
			'<script src="https://gist.github.com/{@id}.js"/>',
			NULL,
			array('attributes' => array('id' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe: <SCRIPT src="{@url}"/>
	*/
	public function testCheckUnsafe22C6B53D()
	{
		$this->testCheckUnsafe(
			'<SCRIPT src="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script SRC="{@url}"/>
	*/
	public function testCheckUnsafe4C83A1C2()
	{
		$this->testCheckUnsafe(
			'<script SRC="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></script>
	*/
	public function testCheckUnsafe0852D347()
	{
		$this->testCheckUnsafe(
			'<script><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></script>',
			"The template contains a 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:attribute name="SRC"><xsl:value-of select="@url"/></xsl:attribute></script>
	*/
	public function testCheckUnsafe28F6AB47()
	{
		$this->testCheckUnsafe(
			'<script><xsl:attribute name="SRC"><xsl:value-of select="@url"/></xsl:attribute></script>',
			"The template contains a 'script' element with a dynamically generated 'SRC' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script src="http://example.org/legit.js"><xsl:attribute name="src"><xsl:value-of select="@hax"/></xsl:attribute></script>
	*/
	public function testCheckUnsafe2B0FC129()
	{
		$this->testCheckUnsafe(
			'<script src="http://example.org/legit.js"><xsl:attribute name="src"><xsl:value-of select="@hax"/></xsl:attribute></script>',
			"The template contains a 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <xsl:element name="script"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>
	*/
	public function testCheckUnsafe8127EF08()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="script"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>',
			"The template contains a dynamically generated 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <xsl:element name="SCRIPT"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>
	*/
	public function testCheckUnsafeC08FCE07()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="SCRIPT"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>',
			"The template contains a dynamically generated 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <b disable-output-escaping="1"/>
	*/
	public function testCheckUnsafeCCAC3746()
	{
		$this->testCheckUnsafe(
			'<b disable-output-escaping="1"/>',
			"The template contains a 'disable-output-escaping' attribute"
		);
	}

	/**
	* @testdox Not safe: <xsl:copy/>
	*/
	public function testCheckUnsafe60753852()
	{
		$this->testCheckUnsafe(
			'<xsl:copy/>',
			"Cannot assess the safety of an 'xsl:copy' element"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:copy-of select="@onclick"/></b>
	*/
	public function testCheckUnsafeC19FCB6D()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select="@onclick"/></b>',
			"Undefined attribute 'onclick'"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:copy-of select=" @ onclick "/></b>
	*/
	public function testCheckUnsafeE26527B5()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select=" @ onclick "/></b>',
			"Undefined attribute 'onclick'"
		);
	}

	/**
	* @testdox Safe: <b><xsl:copy-of select="@title"/></b>
	*/
	public function testCheckUnsafe990F4294()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select="@title"/></b>'
		);
	}

	/**
	* @testdox Safe: <b><xsl:copy-of select=" @ title "/></b>
	*/
	public function testCheckUnsafe358E72E5()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select=" @ title "/></b>'
		);
	}

	/**
	* @testdox Not safe if attribute 'href' has no filter: <a><xsl:copy-of select="@href"/></a>
	*/
	public function testCheckUnsafeE6B9D02C()
	{
		$this->testCheckUnsafe(
			'<a><xsl:copy-of select="@href"/></a>',
			"Attribute 'href' is not properly filtered to be used in URL",
			array('attributes' => array('href' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'href' has filter '#url': <a><xsl:copy-of select="@href"/></a>
	*/
	public function testCheckUnsafeFE9871D1()
	{
		$this->testCheckUnsafe(
			'<a><xsl:copy-of select="@href"/></a>',
			NULL,
			array('attributes' => array('href' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Not safe: <xsl:copy-of select="script"/>
	*/
	public function testCheckUnsafeC8E8CC43()
	{
		$this->testCheckUnsafe(
			'<xsl:copy-of select="script"/>',
			"Cannot assess 'xsl:copy-of' select expression 'script' to be safe"
		);
	}

	/**
	* @testdox Not safe: <xsl:copy-of select=" script "/>
	*/
	public function testCheckUnsafe10D2139E()
	{
		$this->testCheckUnsafe(
			'<xsl:copy-of select=" script "/>',
			"Cannot assess 'xsl:copy-of' select expression 'script' to be safe"
		);
	}

	/**
	* @testdox Not safe: <xsl:copy-of select="parent::*"/>
	*/
	public function testCheckUnsafe1BDDD975()
	{
		$this->testCheckUnsafe(
			'<xsl:copy-of select="parent::*"/>',
			"Cannot assess 'xsl:copy-of' select expression 'parent::*' to be safe"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:apply-templates/></script>
	*/
	public function testCheckUnsafe87044075()
	{
		$this->testCheckUnsafe(
			'<script><xsl:apply-templates/></script>',
			"A 'script' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:apply-templates select="st"/></script>
	*/
	public function testCheckUnsafeC968EED0()
	{
		$this->testCheckUnsafe(
			'<script><xsl:apply-templates select="st"/></script>',
			"Cannot assess the safety of 'xsl:apply-templates' select expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:if test="1"><xsl:apply-templates/></xsl:if></script>
	*/
	public function testCheckUnsafeCC87BEB3()
	{
		$this->testCheckUnsafe(
			'<script><xsl:if test="1"><xsl:apply-templates/></xsl:if></script>',
			"A 'script' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:value-of select="st"/></script>
	*/
	public function testCheckUnsafe5D562F28()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="st"/></script>',
			"Cannot assess the safety of XPath expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeAA242A38()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeBD7323B9()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <script><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></script>
	*/
	public function testCheckUnsafe648A7C72()
	{
		$this->testCheckUnsafe(
			'<script><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></script>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="script"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafeD7E78277()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="script"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="SCRIPT"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafeF7D14089()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="SCRIPT"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has filter 'urlencode': <script><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></script>
	*/
	public function testCheckUnsafeDD1F8AFC()
	{
		$this->testCheckUnsafe(
			'<script><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></script>',
			"Cannot evaluate context node due to 'xsl:for-each'",
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe3E82294D()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe80E31E96()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe66FA78F6()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeBEC2826B()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe58430C01()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe196B1007()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeF128A882()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe585E44A6()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe61A72488()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe: <style><xsl:apply-templates/></style>
	*/
	public function testCheckUnsafe9332F4DA()
	{
		$this->testCheckUnsafe(
			'<style><xsl:apply-templates/></style>',
			"A 'style' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:apply-templates select="st"/></style>
	*/
	public function testCheckUnsafeE7A11344()
	{
		$this->testCheckUnsafe(
			'<style><xsl:apply-templates select="st"/></style>',
			"Cannot assess the safety of 'xsl:apply-templates' select expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:if test="1"><xsl:apply-templates/></xsl:if></style>
	*/
	public function testCheckUnsafe0F7C3E8F()
	{
		$this->testCheckUnsafe(
			'<style><xsl:if test="1"><xsl:apply-templates/></xsl:if></style>',
			"A 'style' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:value-of select="st"/></style>
	*/
	public function testCheckUnsafeF4114812()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="st"/></style>',
			"Cannot assess the safety of XPath expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafeFD7FAE5C()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe2BEA39BA()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <style><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></style>
	*/
	public function testCheckUnsafe489BADA7()
	{
		$this->testCheckUnsafe(
			'<style><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></style>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="style"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafeFC0D6B8F()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="style"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="STYLE"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafe9092B290()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="STYLE"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has filter '#url': <style><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></style>
	*/
	public function testCheckUnsafeD5AD8427()
	{
		$this->testCheckUnsafe(
			'<style><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></style>',
			"Cannot evaluate context node due to 'xsl:for-each'",
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafeA85C9010()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe70646A8D()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe11E4EDA4()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafeBF9EE081()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#color': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe5B459886()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#color'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe57DD5804()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe5C239743()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe8D374457()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe: <b><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>
	*/
	public function testCheckUnsafeCC20E4F6()
	{
		$this->testCheckUnsafe(
			'<b><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>',
			"A dynamically generated 'onclick' attribute lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:attribute name="ONCLICK"><xsl:apply-templates/></xsl:attribute></b>
	*/
	public function testCheckUnsafe31C90A06()
	{
		$this->testCheckUnsafe(
			'<b><xsl:attribute name="ONCLICK"><xsl:apply-templates/></xsl:attribute></b>',
			"A dynamically generated 'ONCLICK' attribute lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <b onclick=""><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>
	*/
	public function testCheckUnsafe6519C7B2()
	{
		$this->testCheckUnsafe(
			'<b onclick=""><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>',
			"A dynamically generated 'onclick' attribute lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:if test="1"><xsl:attribute name="onclick"><xsl:value-of select="@foo"/></xsl:attribute></xsl:if></b>
	*/
	public function testCheckUnsafeF4D2CDD1()
	{
		$this->testCheckUnsafe(
			'<b><xsl:if test="1"><xsl:attribute name="onclick"><xsl:value-of select="@foo"/></xsl:attribute></xsl:if></b>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:attribute name="onclick"><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></xsl:attribute></b>
	*/
	public function testCheckUnsafeCF6CEF14()
	{
		$this->testCheckUnsafe(
			'<b><xsl:attribute name="onclick"><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></xsl:attribute></b>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe: <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe7A1C2C9E()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe: <b ONCLICK="{@foo}"/>
	*/
	public function testCheckUnsafe3DB3E070()
	{
		$this->testCheckUnsafe(
			'<b ONCLICK="{@foo}"/>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <b style="{@foo}"/>
	*/
	public function testCheckUnsafeCFE3D31C()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe0A9E5F7B()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeD2A6A5E6()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeCB2697BB()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe324C2F0E()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#color': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeD6975709()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#color'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeDA0F978B()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe21A9DB3D()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe6C246491()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeF82217B5()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeCF26F70E()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe8E844A18()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe47C79FE4()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe9FFF6579()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeABDB40AE()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe5FF13632()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeB7B28EB7()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe0EAB1AA3()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeDD7B9880()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe55C38875()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeC3FBEAF2()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe6BEA245D()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeCC5BC677()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe14633CEA()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeC2561E09()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe172A8D27()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeFF6935A2()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe633E25F3()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe66ABD04D()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <form action="{@foo}"/>
	*/
	public function testCheckUnsafe4545A54D()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeD213C6F9()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe71AB45CE()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeF536BBFC()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe5C18A403()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe2D0E4161()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeB80529DC()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeE1E9F84B()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe09AA40CE()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe27CCCBF5()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe4BB1ACC7()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeE946770E()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeD841BFC2()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeB7F930C1()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe210BF52A()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe6FC1CA5C()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeE02FAA46()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeF16BA892()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe19281017()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeD8D323D5()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe37A16260()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe52EEA27B()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe358F4452()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeAA86F794()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeE9DCC43A()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe72BE0D09()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeFB3370FA()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe33A74BEF()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeDBE4F36A()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeF6A5E2B7()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe8822BDBC()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe5CD442A0()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeAF295914()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeC2547D2A()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeE6E582E8()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe1A6C87B7()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeD7823CFB()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe448CCA35()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeACCF72B0()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe90D4F2FC()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <a href="{@foo}"/>
	*/
	public function testCheckUnsafeFF6EB164()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe56410B36()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeA4AAC662()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe8DB3BDCC()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeDED7364B()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe558B4751()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe9EA49C76()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeD7CC1308()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe3F8FAB8D()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeC82FFE34()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeF2542B4A()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe264FD1D8()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeDC921C3D()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe211F359B()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeCEA62160()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeF927CF06()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe6B07F4A9()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeC1557F25()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe2916C7A0()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe8DE63B2D()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe90D5A413()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe3120DE12()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeAF88A7CD()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe6541AB3E()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe9415F70C()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeBD7951A3()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeCDFFFD50()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe0592CD94()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeEDD17511()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe31447F85()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <img src="{@foo}"/>
	*/
	public function testCheckUnsafeF39CC4CF()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe4F706364()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe215C34A1()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe7149BFB6()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe9D5D3010()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <img src="{@foo}"/>
	*/
	public function testCheckUnsafeA971452B()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe2E88FE56()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <img src="{@foo}"/>
	*/
	public function testCheckUnsafeEC121FA2()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe0451A727()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <img src="{@foo}"/>
	*/
	public function testCheckUnsafeFE176ACE()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe2A2871AB()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe22EF91DE()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe2009B6D1()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe72F64F38()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe944FB292()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafeAACEB5A5()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe248BEF81()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafeF4AF5BC4()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe1CECE341()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe5ADE13E7()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe: <embed src="{@url}"/>
	*/
	public function testCheckUnsafeFFEA6CBF()
	{
		$this->testCheckUnsafe(
			'<embed src="{@url}"/>',
			"The template contains a 'embed' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <iframe src="{@url}"/>
	*/
	public function testCheckUnsafeA56D0DBC()
	{
		$this->testCheckUnsafe(
			'<iframe src="{@url}"/>',
			"The template contains a 'iframe' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <object data="{@url}"/>
	*/
	public function testCheckUnsafe200651EB()
	{
		$this->testCheckUnsafe(
			'<object data="{@url}"/>',
			"The template contains a 'object' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script src="{@url}"/>
	*/
	public function testCheckUnsafeFDDAD6DB()
	{
		$this->testCheckUnsafe(
			'<script src="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe if attribute 'id' has filter '#url': <script src="{@url}"/>
	*/
	public function testCheckUnsafeD10CCD19()
	{
		$this->testCheckUnsafe(
			'<script src="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL",
			array('attributes' => array('id' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'id' has filter '#number': <script src="https://gist.github.com/{@id}.js"/>
	*/
	public function testCheckUnsafe6C30CE54()
	{
		$this->testCheckUnsafe(
			'<script src="https://gist.github.com/{@id}.js"/>',
			NULL,
			array('attributes' => array('id' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe: <SCRIPT src="{@url}"/>
	*/
	public function testCheckUnsafe22C6B53D()
	{
		$this->testCheckUnsafe(
			'<SCRIPT src="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script SRC="{@url}"/>
	*/
	public function testCheckUnsafe4C83A1C2()
	{
		$this->testCheckUnsafe(
			'<script SRC="{@url}"/>',
			"The template contains a 'script' element with a non-fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></script>
	*/
	public function testCheckUnsafe0852D347()
	{
		$this->testCheckUnsafe(
			'<script><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></script>',
			"The template contains a 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:attribute name="SRC"><xsl:value-of select="@url"/></xsl:attribute></script>
	*/
	public function testCheckUnsafe28F6AB47()
	{
		$this->testCheckUnsafe(
			'<script><xsl:attribute name="SRC"><xsl:value-of select="@url"/></xsl:attribute></script>',
			"The template contains a 'script' element with a dynamically generated 'SRC' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <script src="http://example.org/legit.js"><xsl:attribute name="src"><xsl:value-of select="@hax"/></xsl:attribute></script>
	*/
	public function testCheckUnsafe2B0FC129()
	{
		$this->testCheckUnsafe(
			'<script src="http://example.org/legit.js"><xsl:attribute name="src"><xsl:value-of select="@hax"/></xsl:attribute></script>',
			"The template contains a 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <xsl:element name="script"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>
	*/
	public function testCheckUnsafe8127EF08()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="script"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>',
			"The template contains a dynamically generated 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <xsl:element name="SCRIPT"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>
	*/
	public function testCheckUnsafeC08FCE07()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="SCRIPT"><xsl:attribute name="src"><xsl:value-of select="@url"/></xsl:attribute></xsl:element>',
			"The template contains a dynamically generated 'script' element with a dynamically generated 'src' attribute that does not use a fixed URL"
		);
	}

	/**
	* @testdox Not safe: <b disable-output-escaping="1"/>
	*/
	public function testCheckUnsafeCCAC3746()
	{
		$this->testCheckUnsafe(
			'<b disable-output-escaping="1"/>',
			"The template contains a 'disable-output-escaping' attribute"
		);
	}

	/**
	* @testdox Not safe: <xsl:copy/>
	*/
	public function testCheckUnsafe60753852()
	{
		$this->testCheckUnsafe(
			'<xsl:copy/>',
			"Cannot assess the safety of an 'xsl:copy' element"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:copy-of select="@onclick"/></b>
	*/
	public function testCheckUnsafeC19FCB6D()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select="@onclick"/></b>',
			"Undefined attribute 'onclick'"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:copy-of select=" @ onclick "/></b>
	*/
	public function testCheckUnsafeE26527B5()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select=" @ onclick "/></b>',
			"Undefined attribute 'onclick'"
		);
	}

	/**
	* @testdox Safe: <b><xsl:copy-of select="@title"/></b>
	*/
	public function testCheckUnsafe990F4294()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select="@title"/></b>'
		);
	}

	/**
	* @testdox Safe: <b><xsl:copy-of select=" @ title "/></b>
	*/
	public function testCheckUnsafe358E72E5()
	{
		$this->testCheckUnsafe(
			'<b><xsl:copy-of select=" @ title "/></b>'
		);
	}

	/**
	* @testdox Not safe if attribute 'href' has no filter: <a><xsl:copy-of select="@href"/></a>
	*/
	public function testCheckUnsafeE6B9D02C()
	{
		$this->testCheckUnsafe(
			'<a><xsl:copy-of select="@href"/></a>',
			"Attribute 'href' is not properly filtered to be used in URL",
			array('attributes' => array('href' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'href' has filter '#url': <a><xsl:copy-of select="@href"/></a>
	*/
	public function testCheckUnsafeFE9871D1()
	{
		$this->testCheckUnsafe(
			'<a><xsl:copy-of select="@href"/></a>',
			NULL,
			array('attributes' => array('href' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Not safe: <xsl:copy-of select="script"/>
	*/
	public function testCheckUnsafeC8E8CC43()
	{
		$this->testCheckUnsafe(
			'<xsl:copy-of select="script"/>',
			"Cannot assess 'xsl:copy-of' select expression 'script' to be safe"
		);
	}

	/**
	* @testdox Not safe: <xsl:copy-of select=" script "/>
	*/
	public function testCheckUnsafe10D2139E()
	{
		$this->testCheckUnsafe(
			'<xsl:copy-of select=" script "/>',
			"Cannot assess 'xsl:copy-of' select expression 'script' to be safe"
		);
	}

	/**
	* @testdox Not safe: <xsl:copy-of select="parent::*"/>
	*/
	public function testCheckUnsafe1BDDD975()
	{
		$this->testCheckUnsafe(
			'<xsl:copy-of select="parent::*"/>',
			"Cannot assess 'xsl:copy-of' select expression 'parent::*' to be safe"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:apply-templates/></script>
	*/
	public function testCheckUnsafe87044075()
	{
		$this->testCheckUnsafe(
			'<script><xsl:apply-templates/></script>',
			"A 'script' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:apply-templates select="st"/></script>
	*/
	public function testCheckUnsafeC968EED0()
	{
		$this->testCheckUnsafe(
			'<script><xsl:apply-templates select="st"/></script>',
			"Cannot assess the safety of 'xsl:apply-templates' select expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:if test="1"><xsl:apply-templates/></xsl:if></script>
	*/
	public function testCheckUnsafeCC87BEB3()
	{
		$this->testCheckUnsafe(
			'<script><xsl:if test="1"><xsl:apply-templates/></xsl:if></script>',
			"A 'script' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:value-of select="st"/></script>
	*/
	public function testCheckUnsafe5D562F28()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="st"/></script>',
			"Cannot assess the safety of XPath expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeAA242A38()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeBD7323B9()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <script><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></script>
	*/
	public function testCheckUnsafe648A7C72()
	{
		$this->testCheckUnsafe(
			'<script><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></script>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="script"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafeD7E78277()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="script"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="SCRIPT"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafeF7D14089()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="SCRIPT"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has filter 'urlencode': <script><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></script>
	*/
	public function testCheckUnsafeDD1F8AFC()
	{
		$this->testCheckUnsafe(
			'<script><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></script>',
			"Cannot evaluate context node due to 'xsl:for-each'",
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe3E82294D()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe80E31E96()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe66FA78F6()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeBEC2826B()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe58430C01()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe196B1007()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafeF128A882()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe585E44A6()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <script><xsl:value-of select="@foo"/></script>
	*/
	public function testCheckUnsafe61A72488()
	{
		$this->testCheckUnsafe(
			'<script><xsl:value-of select="@foo"/></script>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe: <style><xsl:apply-templates/></style>
	*/
	public function testCheckUnsafe9332F4DA()
	{
		$this->testCheckUnsafe(
			'<style><xsl:apply-templates/></style>',
			"A 'style' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:apply-templates select="st"/></style>
	*/
	public function testCheckUnsafeE7A11344()
	{
		$this->testCheckUnsafe(
			'<style><xsl:apply-templates select="st"/></style>',
			"Cannot assess the safety of 'xsl:apply-templates' select expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:if test="1"><xsl:apply-templates/></xsl:if></style>
	*/
	public function testCheckUnsafe0F7C3E8F()
	{
		$this->testCheckUnsafe(
			'<style><xsl:if test="1"><xsl:apply-templates/></xsl:if></style>',
			"A 'style' element lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:value-of select="st"/></style>
	*/
	public function testCheckUnsafeF4114812()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="st"/></style>',
			"Cannot assess the safety of XPath expression 'st'"
		);
	}

	/**
	* @testdox Not safe: <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafeFD7FAE5C()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe2BEA39BA()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <style><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></style>
	*/
	public function testCheckUnsafe489BADA7()
	{
		$this->testCheckUnsafe(
			'<style><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></style>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="style"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafeFC0D6B8F()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="style"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xsl:element name="STYLE"><xsl:value-of select="@foo"/></xsl:element>
	*/
	public function testCheckUnsafe9092B290()
	{
		$this->testCheckUnsafe(
			'<xsl:element name="STYLE"><xsl:value-of select="@foo"/></xsl:element>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has filter '#url': <style><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></style>
	*/
	public function testCheckUnsafeD5AD8427()
	{
		$this->testCheckUnsafe(
			'<style><xsl:for-each select="/*"><xsl:value-of select="@foo"/></xsl:for-each></style>',
			"Cannot evaluate context node due to 'xsl:for-each'",
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafeA85C9010()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe70646A8D()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe11E4EDA4()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafeBF9EE081()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#color': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe5B459886()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#color'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe57DD5804()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe5C239743()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <style><xsl:value-of select="@foo"/></style>
	*/
	public function testCheckUnsafe8D374457()
	{
		$this->testCheckUnsafe(
			'<style><xsl:value-of select="@foo"/></style>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe: <b><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>
	*/
	public function testCheckUnsafeCC20E4F6()
	{
		$this->testCheckUnsafe(
			'<b><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>',
			"A dynamically generated 'onclick' attribute lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:attribute name="ONCLICK"><xsl:apply-templates/></xsl:attribute></b>
	*/
	public function testCheckUnsafe31C90A06()
	{
		$this->testCheckUnsafe(
			'<b><xsl:attribute name="ONCLICK"><xsl:apply-templates/></xsl:attribute></b>',
			"A dynamically generated 'ONCLICK' attribute lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <b onclick=""><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>
	*/
	public function testCheckUnsafe6519C7B2()
	{
		$this->testCheckUnsafe(
			'<b onclick=""><xsl:attribute name="onclick"><xsl:apply-templates/></xsl:attribute></b>',
			"A dynamically generated 'onclick' attribute lets unfiltered data through"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:if test="1"><xsl:attribute name="onclick"><xsl:value-of select="@foo"/></xsl:attribute></xsl:if></b>
	*/
	public function testCheckUnsafeF4D2CDD1()
	{
		$this->testCheckUnsafe(
			'<b><xsl:if test="1"><xsl:attribute name="onclick"><xsl:value-of select="@foo"/></xsl:attribute></xsl:if></b>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe: <b><xsl:attribute name="onclick"><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></xsl:attribute></b>
	*/
	public function testCheckUnsafeCF6CEF14()
	{
		$this->testCheckUnsafe(
			'<b><xsl:attribute name="onclick"><xsl:if test="1"><xsl:value-of select="@foo"/></xsl:if></xsl:attribute></b>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe: <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe7A1C2C9E()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe: <b ONCLICK="{@foo}"/>
	*/
	public function testCheckUnsafe3DB3E070()
	{
		$this->testCheckUnsafe(
			'<b ONCLICK="{@foo}"/>',
			"Undefined attribute 'foo'"
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <b style="{@foo}"/>
	*/
	public function testCheckUnsafeCFE3D31C()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in CSS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe0A9E5F7B()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeD2A6A5E6()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeCB2697BB()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe324C2F0E()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#color': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeD6975709()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#color'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <b style="{@foo}"/>
	*/
	public function testCheckUnsafeDA0F978B()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe21A9DB3D()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <b style="{@foo}"/>
	*/
	public function testCheckUnsafe6C246491()
	{
		$this->testCheckUnsafe(
			'<b style="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeF82217B5()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeCF26F70E()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe8E844A18()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe47C79FE4()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe9FFF6579()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeABDB40AE()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe5FF13632()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeB7B28EB7()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafe0EAB1AA3()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <b onclick="{@foo}"/>
	*/
	public function testCheckUnsafeDD7B9880()
	{
		$this->testCheckUnsafe(
			'<b onclick="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe55C38875()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in JS",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeC3FBEAF2()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe6BEA245D()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeCC5BC677()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe14633CEA()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeC2561E09()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe172A8D27()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafeFF6935A2()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe633E25F3()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#simpletext': <b onanything="{@foo}"/>
	*/
	public function testCheckUnsafe66ABD04D()
	{
		$this->testCheckUnsafe(
			'<b onanything="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#simpletext'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <form action="{@foo}"/>
	*/
	public function testCheckUnsafe4545A54D()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeD213C6F9()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe71AB45CE()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeF536BBFC()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe5C18A403()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe2D0E4161()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeB80529DC()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <form action="{@foo}"/>
	*/
	public function testCheckUnsafeE1E9F84B()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe09AA40CE()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <form action="{@foo}"/>
	*/
	public function testCheckUnsafe27CCCBF5()
	{
		$this->testCheckUnsafe(
			'<form action="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe4BB1ACC7()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeE946770E()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeD841BFC2()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeB7F930C1()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe210BF52A()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe6FC1CA5C()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeE02FAA46()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeF16BA892()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafe19281017()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <q cite="{@foo}"/>
	*/
	public function testCheckUnsafeD8D323D5()
	{
		$this->testCheckUnsafe(
			'<q cite="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe37A16260()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe52EEA27B()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe358F4452()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeAA86F794()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeE9DCC43A()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe72BE0D09()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeFB3370FA()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafe33A74BEF()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeDBE4F36A()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <xbject data="{@foo}"/>
	*/
	public function testCheckUnsafeF6A5E2B7()
	{
		$this->testCheckUnsafe(
			'<xbject data="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe8822BDBC()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe5CD442A0()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeAF295914()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeC2547D2A()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeE6E582E8()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe1A6C87B7()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeD7823CFB()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe448CCA35()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafeACCF72B0()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <input formaction="{@foo}"/>
	*/
	public function testCheckUnsafe90D4F2FC()
	{
		$this->testCheckUnsafe(
			'<input formaction="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <a href="{@foo}"/>
	*/
	public function testCheckUnsafeFF6EB164()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe56410B36()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeA4AAC662()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe8DB3BDCC()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeDED7364B()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe558B4751()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe9EA49C76()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeD7CC1308()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <a href="{@foo}"/>
	*/
	public function testCheckUnsafe3F8FAB8D()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <a href="{@foo}"/>
	*/
	public function testCheckUnsafeC82FFE34()
	{
		$this->testCheckUnsafe(
			'<a href="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeF2542B4A()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe264FD1D8()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeDC921C3D()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe211F359B()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeCEA62160()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeF927CF06()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe6B07F4A9()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafeC1557F25()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe2916C7A0()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <html manifest="{@foo}"/>
	*/
	public function testCheckUnsafe8DE63B2D()
	{
		$this->testCheckUnsafe(
			'<html manifest="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe90D5A413()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe3120DE12()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeAF88A7CD()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe6541AB3E()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe9415F70C()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeBD7951A3()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeCDFFFD50()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe0592CD94()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafeEDD17511()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <video poster="{@foo}"/>
	*/
	public function testCheckUnsafe31447F85()
	{
		$this->testCheckUnsafe(
			'<video poster="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <img src="{@foo}"/>
	*/
	public function testCheckUnsafeF39CC4CF()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe4F706364()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe215C34A1()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe7149BFB6()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe9D5D3010()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <img src="{@foo}"/>
	*/
	public function testCheckUnsafeA971452B()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe2E88FE56()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <img src="{@foo}"/>
	*/
	public function testCheckUnsafeEC121FA2()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <img src="{@foo}"/>
	*/
	public function testCheckUnsafe0451A727()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <img src="{@foo}"/>
	*/
	public function testCheckUnsafeFE176ACE()
	{
		$this->testCheckUnsafe(
			'<img src="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}

	/**
	* @testdox Not safe if attribute 'foo' has no filter: <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe2A2871AB()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			"Attribute 'foo' is not properly filtered to be used in URL",
			array('attributes' => array('foo' => array()))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'urlencode': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe22EF91DE()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('urlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter 'rawurlencode': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe2009B6D1()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('rawurlencode'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#url': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe72F64F38()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#url'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#id': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe944FB292()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#id'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#int': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafeAACEB5A5()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#int'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#uint': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe248BEF81()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#uint'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#float': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafeF4AF5BC4()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#float'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#range': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe1CECE341()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#range'))))
		);
	}

	/**
	* @testdox Safe if attribute 'foo' has filter '#number': <img lowsrc="{@foo}"/>
	*/
	public function testCheckUnsafe5ADE13E7()
	{
		$this->testCheckUnsafe(
			'<img lowsrc="{@foo}"/>',
			NULL,
			array('attributes' => array('foo' => array('filterChain' => array('#number'))))
		);
	}
