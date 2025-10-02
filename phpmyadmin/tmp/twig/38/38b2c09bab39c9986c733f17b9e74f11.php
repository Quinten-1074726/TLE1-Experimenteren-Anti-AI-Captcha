<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* table/maintenance/check.twig */
class __TwigTemplate_19085343874a501b1929b2cbaad63024 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<div class=\"container-fluid\">
  <h2>
    ";
yield _gettext("Check table");
        // line 4
        yield "    ";
        yield PhpMyAdmin\Html\MySQLDocumentation::show("CHECK_TABLE");
        yield "
  </h2>

  ";
        // line 7
        yield ($context["message"] ?? null);
        yield "

  ";
        // line 9
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["rows"] ?? null));
        foreach ($context['_seq'] as $context["name"] => $context["table"]) {
            // line 10
            yield "    <div class=\"card mb-3\">
      <div class=\"card-header\">";
            // line 11
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["name"], "html", null, true);
            yield "</div>

      <ul class=\"list-group list-group-flush\">
        ";
            // line 14
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["table"]);
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 15
                yield "          <li class=\"list-group-item\">
            ";
                // line 16
                if ((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "operation", [], "any", false, false, false, 16)) != "check")) {
                    // line 17
                    yield "              <span class=\"badge bg-secondary\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "operation", [], "any", false, false, false, 17)), "html", null, true);
                    yield "</span>
            ";
                }
                // line 19
                yield "
            ";
                // line 20
                $context["badge_variation"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                    // line 21
                    if ((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "type", [], "any", false, false, false, 21)) == "error")) {
                        // line 22
                        yield "bg-danger";
                    } elseif ((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source,                     // line 23
$context["row"], "type", [], "any", false, false, false, 23)) == "warning")) {
                        // line 24
                        yield "bg-warning";
                    } elseif (((Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source,                     // line 25
$context["row"], "type", [], "any", false, false, false, 25)) == "info") || (Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "type", [], "any", false, false, false, 25)) == "note"))) {
                        // line 26
                        yield "bg-info";
                    } else {
                        // line 28
                        yield "bg-secondary";
                    }
                    return; yield '';
                })())) ? '' : new Markup($tmp, $this->env->getCharset());
                // line 31
                yield "            <span class=\"badge ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["badge_variation"] ?? null), "html", null, true);
                yield "\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["row"], "type", [], "any", false, false, false, 31)), "html", null, true);
                yield "</span>

            ";
                // line 33
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "text", [], "any", false, false, false, 33), "html", null, true);
                yield "
          </li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 36
            yield "      </ul>
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['name'], $context['table'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 39
        yield "
  ";
        // line 40
        yield ($context["indexes_problems"] ?? null);
        yield "
</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "table/maintenance/check.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  134 => 40,  131 => 39,  123 => 36,  114 => 33,  106 => 31,  101 => 28,  98 => 26,  96 => 25,  94 => 24,  92 => 23,  90 => 22,  88 => 21,  86 => 20,  83 => 19,  77 => 17,  75 => 16,  72 => 15,  68 => 14,  62 => 11,  59 => 10,  55 => 9,  50 => 7,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/maintenance/check.twig", "C:\\Users\\erkek\\Documents\\TLE1 opdracht\\TLE 1 teamscode\\TLE1-Experimenteren-Anti-AI-Captcha\\phpmyadmin\\templates\\table\\maintenance\\check.twig");
    }
}
