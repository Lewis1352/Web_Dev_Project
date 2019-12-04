<?php

/* display_result.html.twig */
class __TwigTemplate_01bdaafdcbe2c68b4c8bb26b4ceb16b27dae74af5f8cc04966ae5c654fb848e6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("banner.html.twig", "display_result.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "banner.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = array())
    {
        // line 3
        echo "    <h2>";
        echo twig_escape_filter($this->env, ($context["page_heading_2"] ?? null), "html", null, true);
        echo "</h2>
    <p>";
        // line 4
        echo twig_escape_filter($this->env, ($context["page_text"] ?? null), "html", null, true);
        echo "</p>
    <p>Company selected was <b>";
        // line 5
        echo twig_escape_filter($this->env, ($context["company_name"] ?? null), "html", null, true);
        echo "</b></p>
    <h3>Stock Data</h3>
    <table border=\"1\">
      <tbody>
      <tr><th>Date</th><th>Time</th><th>Stock Value</th></tr>
      ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["company_data_set"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["stock_data"]) {
            // line 11
            echo "        <tr><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["stock_data"], "date", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["stock_data"], "time", array()), "html", null, true);
            echo "</td><td>";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), $context["stock_data"], "value", array()), "html", null, true);
            echo "</td></tr>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stock_data'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </tbody>
    </table>
    <br />
    <h3>Line Chart</h3>
    <img src=\"";
        // line 17
        echo twig_escape_filter($this->env, ($context["chart_location"] ?? null), "html", null, true);
        echo "\" />
    <br />
    <br />
    <p class=\"curr_page\"><a href=\"";
        // line 20
        echo twig_escape_filter($this->env, ($context["landing_page"] ?? null), "html", null, true);
        echo "\">Another Company</a></p>
";
    }

    public function getTemplateName()
    {
        return "display_result.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 20,  71 => 17,  65 => 13,  52 => 11,  48 => 10,  40 => 5,  36 => 4,  31 => 3,  28 => 2,  11 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "display_result.html.twig", "/p3t/phpappfolder/includes/stockquotes/app/templates/display_result.html.twig");
    }
}
